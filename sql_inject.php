<?PHP


class sql_inject
{
    /**
	 * @shortdesc url to redirect if an sql inject attempt is detect. if unset, value is FALSE
	 * @private
	 * @type mixed
	 */
    var $urlRedirect;
    /**
	 * @shortdesc does the session must be destroy if an attempt is detect
	 * @private
	 * @type bool
	 */
    var $bdestroy_session;
    /**
	 * @shortdesc the SQL data currently test
	 * @private
	 * @type string
	 */
    var $rq;
    /**
	 * @shortdesc if not FALSE, the url to the log file
	 * @private
	 * @type mixed
	 */
    var $bLog;
    
    /**
	 * Builder
	 *
	 * @param bool bdestroy_session optional. does the session must be destroy if an attempt is detect?
	 * @param string urlRedirect optional. url to redirect if an sql inject attempt is detect
     * @public
	 * @type void
     */
    function sql_inject($mLog=FALSE,$bdestroy_session=FALSE,$urlRedirect=FALSE)
    {
        $this->bLog = (($mLog!=FALSE)?$mLog:'');
        $this->urlRedirect = (((trim($urlRedirect)!='') && file_exists($urlRedirect))?$urlRedirect:'');
        $this->bdestroy_session = $bdestroy_session;
        $this->rq = '';
    }

    /**
	 * @shortdesc test if there is a sql inject attempt detect
	 * test if there is a sql inject attempt detect
	 *
	 * @param string sRQ required. SQL Data to test
     * @public
	 * @type bool
     */
    function test($sRQ)
    {
        $sRQ = strtolower($sRQ);
        $this->rq = $sRQ;
        $aValues = array();
        $aTemp = array(); // temp array
        $aWords = array(); //
        $aSep = array(' and ',' or '); // separators for detect the
        $sConditions = '(';
        $matches = array();
        $sSep = '';
        // is there an attempt to unused part of the rq?
        if (is_int((strpos($sRQ,"#")))&&$this->_in_post('#')) return $this->detect();
        
        // is there a attempt to do a 2nd SQL requete ?
        if (is_int(strpos($sRQ,';'))){
            $aTemp = explode(';',$sRQ);
            if ($this->_in_post($aTemp[1])) return $this->detect();
        }
        
        $aTemp = explode(" where ",$sRQ);
        if (count($aTemp)==1) return FALSE;
        $sConditions = $aTemp[1];
        $aWords = explode(" ",$sConditions);
        if(strcasecmp($aWords[0],'select')!=0) $aSep[] = ',';
        $sSep = '('.implode('|',$aSep).')';
        $aValues = preg_split($sSep,$sConditions,-1, PREG_SPLIT_NO_EMPTY);

        // test the always true expressions
        foreach($aValues as $i => $v)
        {
            // SQL injection like 1=1 or a=a or 'za'='za'
            if (is_int(strpos($v,'=')))
            {
                 $aTemp = explode('=',$v);
                 if (trim($aTemp[0])==trim($aTemp[1])) return $this->detect();
            }
            
            //SQL injection like 1<>2
            if (is_int(strpos($v,'<>')))
            {
                $aTemp = explode('<>',$v);
                if ((trim($aTemp[0])!=trim($aTemp[1]))&& ($this->_in_post('<>'))) return $this->detect();
            }
			//SQL injection got '--'
            if (is_int(strpos($v,'--')))
            {
                return $this->detect();
            }
			//SQL injection got ';'
            if (is_int(strpos($v,';')))
            {
                return $this->detect();
            }
        }
        
        if (strpos($sConditions,' null'))
        {
            if (preg_match("/null +is +null/",$sConditions)) return $this->detect();
            if (preg_match("/is +not +null/",$sConditions,$matches))
            {
                foreach($matches as $i => $v)
                {
                    if ($this->_in_post($v))return $this->detect();
                }
            }
        }
        
        if (preg_match("/[a-z0-9]+ +between +[a-z0-9]+ +and +[a-z0-9]+/",$sConditions,$matches))
        {
            $Temp = explode(' between ',$matches[0]);
            $Evaluate = $Temp[0];
            $Temp = explode(' and ',$Temp[1]);
            if ((strcasecmp($Evaluate,$Temp[0])>0) && (strcasecmp($Evaluate,$Temp[1])<0) && $this->_in_post($matches[0])) return $this->detect();
        }
        return FALSE;
    }

    function _in_post($value)
    {
        foreach($_POST as $i => $v)
        {
             if (is_int(strpos(strtolower($v),$value))) return TRUE;
        }
        return FALSE;
    }

    function detect()
    {
        // log the attempt to sql inject?
        if ($this->bLog)
        {
            $fp = @fopen($this->bLog,'a+');
            if ($fp)
            {
                fputs($fp,"\r\n".date("d-m-Y H:i:s").' ['.$this->rq.'] from '.$this->sIp = getenv("REMOTE_ADDR"));
                fclose($fp);
            }
        }
        // destroy session?
        if ($this->bdestroy_session) session_destroy();
        // redirect?
        if ($this->urlRedirect!=''){
             exit("<script>document.location='$this->urlRedirect'</script>");
        }
        return TRUE;
    }


function protect1($protected) { // This Will be the fuction we call to protect the variables.
	$banlist = array ("'", "shutdown", "or ", "--", "or=", "del ", "[", ")--", "Character", "dbo", "WHERE", "Set ", "]", "\"", "<", "\\", "|", "/", "=", "insert", "select", "update", "delete", "distinct", "having", "truncate", "'", "replace", "handler", "like", "procedure", "limit", "order by", "group by", "asc", "warehouse", "DEL ", "$", "sele", "+", "+ dx", " dx", "memb_info", "desc");
	//$banlist is the list of words you dont want to allow.
	if ( eregi ( "[a-zA-Z0-9@]+", $protected ) ) { // Makes sure only legitimate Characters are used.
		$protected = trim(str_replace($banlist, '', $protected)); // Takes out whitespace, and removes any banned words.
		return $protected;
		//echo "+";
	} else {
		//echo "-";
		echo $protected;
		die ( ' Is invalid for that spot, please try a different entry.' ); // Message if thier is any characters not in [a-zA-Z0-9].
	} // ends the if ( eregi ( "[a-zA-Z0-9]+", $this->protected ) ) {
} // ends the function Protect() {

function protect2($protected) { // This Will be the fuction we call to protect the variables.
	$banlist = array ("'", "shutdown", "or", "--","or=", "del", "[", ")--", "Character", "dbo", "WHERE", "Set", "]", "\"", ">", "<", "\\", "|", "/", "=", "insert", "select", "update", "delete", "distinct", "having", "truncate", "'", "replace", "handler", "like", "procedure", "limit", "order by", "group by", "asc", "warehouse", "DEL", "$", "sele", " +", " + ", "+", "+ dx", " dx", "memb_info", "desc"); 
	//$banlist is the list of words you dont want to allow.
	if ( eregi ( "[0-9]+", $protected ) ) { // Makes sure only legitimate Characters are used.
		$protected = trim(str_replace($banlist, '', $protected)); // Takes out whitespace, and removes any banned words.
		return $protected;
		//echo "+";
	} else {
		//echo "-";
		echo $protected;
		die ( ' Caracteres Invalidos' ); // Message if thier is any characters not in [a-zA-Z0-9].
	} // ends the if ( eregi ( "[a-zA-Z0-9]+", $this->protected ) ) {
} // ends the function Protect() {


}
?>
<?php
$badwords = array("+","--)","DEL ","--","'","del ","delete ","DELETE ","INSERT","insert","UPDATE","update","=","DROP","drop ","SELE ","sele ","$","WAREHOUSE","warehouse","DEXTERITY","Dexterity","WHERE ","where ",";","\"","*","UNION ","union ","MEMB ","memb ","SET ","set ","RES3T","res3t","WAREH","wareh","%","=","ADD ","add ","/",",",":","#","\\");
foreach($_POST as $value)
foreach($badwords as $word)
if(substr_count($value, $word) > 0)
?>

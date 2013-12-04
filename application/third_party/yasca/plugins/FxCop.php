<?php

/**  
 * The FxCop plugin is used to find potential vulnerabilities in .NET assemblies.
 * Only the security rules set is used.
 *
 * Created by Michael Maass 07/02/2009
 *
 * @extends Plugin  
 * @package Yasca  
 */  
class Plugin_FxCop extends Plugin {  

    public $valid_file_types = array("exe", "dll");  

    public $is_multi_target = true;

    public $installation_marker = true; 

    public $executable = array('Windows' => ".\\resources\\utility\\fxcop\\fxcop.bat",
	                           'Linux'   => "wine %SA_HOME%/resources/utility/FxCop/FxCopCmd.exe");

    public $arguments = array('Windows' => ' ',
			                  'Linux'   => " /out:scan.xml /rule:%SA_HOME%resources/utility/FxCop/Rules/SecurityRules.dll /rule:%SA_HOME%resources/utility/FxCop/Rules/DesignRules.dll /iit /file:");

    private $severity = array('informational'   => 5,
                              'warning'         => 4,
                              'criticalwarning' => 3,
                              'error'           => 2,
                              'criticalerror'   => 1);

    private $descriptorspec = array( 0 => array("pipe", "r"),
                                     1 => array("pipe", "w"),
                                     2 => array("pipe", "w"));

   /**  
    * Executes the FxCop executable.
    */  
    function execute() {  
        static $alreadyExecuted;  
        if ($alreadyExecuted == 1) return;  
        $alreadyExecuted = 1;  
     
        $yasca =& Yasca::getInstance();  
        $dir = $yasca->options['dir'];  
        $stat_msgs = array();  

        $executable = $this->executable[getSystemOS()];
        $executable = $this->replaceExecutableStrings($executable);

        $arguments = $this->arguments[getSystemOS()];
        $arguments = $this->replaceExecutableStrings($arguments);


        if (getSystemOS() == "Windows") {
            $yasca->log_message("Forking external process (FxCop)...", E_USER_WARNING);
            $yasca->log_message("Executing: [" . $executable . $arguments . escapeshellarg($dir) . "] 2>&1", E_ALL);

            exec($executable . $arguments . "\"" . escapeshellarg($dir) . "\" 2>&1", $output);

            $output = implode("\n", $output);
            $output = substr($output, stripos($output, "<"));

            $yasca->log_message("FxCop Returned: $output", E_ALL);

            $dom = @new DOMDocument();  

            if (!$dom->loadXML($output)) {
                $yasca->log_message("FxCop did not return a valid XML document. Ignoring.", E_USER_WARNING);  
                return;
            }

        } elseif (getSystemOS() == "Linux" && !preg_match("/no wine in/", `which wine`)) {
            $yasca->log_message("Forking external process (FxCop)...", E_USER_WARNING);
            $yasca->log_message("Executing: [" . $executable . $arguments . escapeshellarg($dir) . "] 2>&1", E_ALL);

            exec($executable . $arguments . "\"" . escapeshellarg($dir) . "\" 2>&1", $output);

            $yasca->log_message("FxCop Returned: " . implode("\r\n", $output), E_ALL);

            $dom = @new DOMDocument();  

            if (!file_exists("scan.xml" || !$dom->load("scan.xml"))) {
                $yasca->log_message("FxCop did not return a valid XML document. Ignoring.", E_USER_WARNING);  
                return;
            }

        }

        $yasca->log_message("External process completed...", E_USER_WARNING);

        //Process results
        foreach ($dom->getElementsByTagName("Namespace") as $namespace) {
            if ($namespace->getElementsByTagName("Type")->length == 0)  
        	$this->process_messages($namespace);	    
        }  

        foreach ($dom->getElementsByTagName("Module") as $module) {  
            $this->process_messages($module);	    
        }  

        foreach ($dom->getElementsByTagName("Type") as $type) {
            $this->process_messages($type);	    
        }  

        @unlink("scan.xml");
    }  

    function process_messages($node) {

        foreach($node->getElementsByTagName("Message") as $message) {
            $result = new Result();

            $result->line_number = 0;
            $result->filename = $node->getAttribute("Name");
            $result->plugin_name = $message->getAttribute("TypeName");
            $severity = strtolower(trim($message->getElementsByTagName("Issue")->item(0)->getAttribute("Level")));
            $severity = (isset($this->severity[$severity]) ? $this->severity[$severity] : 5);
            $result->severity = $severity;
            $result->category = "FxCop Security Messages";
            $result->source = $message->getAttribute("CheckId") . ": " . 

       	    $message->getAttribute("TypeName") . " (" . 
		    $message->getAttribute("FixCategory") . ")";

            $result->is_source_code = false;
            $result->source_context = "";

            $result->description = $message->getElementsByTagName("Issue")->item(0)->nodeValue;

            array_push($this->result_list, $result);
        }
    }

}  
?> 

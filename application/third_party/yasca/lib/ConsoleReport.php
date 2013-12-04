<?php

include_once("lib/Report.php");

/**
 * ConsoleReport Class
 *
 * This class renders scan results on the console with no details.
 * @author Michael V. Scovetta <scovetta@users.sourceforge.net>
 * @version 2.0
 * @license see doc/LICENSE
 * @package Yasca
 */

class ConsoleReport extends Report {
    /**
     * The default extension used for reports of this type.
     */
    public $default_extension = "";

    public $uses_file_output = false;
    
    /**
     * Executes a ConsoleReport, with output going to stdout.
     */ 
    function execute() {
        if (!$handle = $this->create_output_handle()) return;
        
        print "Report Output:\n";
        
        $num_results_written = 0;
        foreach ($this->results as $result) {
            if (!$this->is_severity_sufficient($result->severity))
                continue;
            $filename = $result->filename;
            $pinfo = pathinfo($filename);
            $ext = $pinfo['extension'];
            if (isset($result->custom['translation'])) {
                $t = $result->custom['translation'];
                $filename = $t[basename($filename, ".$ext")];
            }
            $filename = str_replace("\\", "/", $filename);      // changed from $result->filename

            $row_id = sprintf("%03d", ++$num_results_written);
            $category_link = $result->category_link;
            $category = $result->category;
            $plugin_name = $result->plugin_name;
            $source = trim($result->source);
            $severity_description = $this->get_severity_description($result->severity);
            $filename_base = basename($filename);
            $line_number = $result->line_number;
            $line_number_field = $result->line_number > 0 ? ":" . $result->line_number : "";
            $category_link_field = "<a href=\"$category_link\" target=\"_blank\">$category</a>";
            if ($category_link == "") $category_link_field = $category;
            
            print "$row_id => $category: $filename_base$line_number_field: $source\n";
        }
        if (count($this->results) == 0) {
            print " No results found.\n";
        }
    }
}



?>

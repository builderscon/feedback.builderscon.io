<?php
namespace App\Classes\TicketImporter;

class PeatixTicketImporter
{
    public static function importFile($file, $conference)
    {

        // Process each line
        $buffer = substr(file_get_contents($file), 2);
        $buffer = iconv('UTF-16LE', 'UTF-8', $buffer);
        $lines = explode("\n", $buffer);
        // Remove header line
        array_shift($lines);

        $concatedLines = [];
        $lastline = '"';
        foreach ($lines as $line){
            $line = trim($line);
            if ($line === ''){ continue; }

            if (substr($line, 0, 1) !== '"' or substr($lastline, -1) !== '"'){
                // This is not a new line
                $concatedLines[count($concatedLines) - 1] .= ' / '.$line;
            } else {
                $concatedLines[] = $line;
            }
            $lastline = $concatedLines[count($concatedLines) - 1];
        }

        // Split with tab
        $records = [];
        foreach ($concatedLines as $line){
            $cols = explode("\t", $line);
            // Remove double quote of head and tail
            for ($idx = 0; $idx < count($cols); $idx++){
                $cols[$idx] = substr($cols[$idx], 1, -1);
            }
            $records[] = $cols;
        }

        // Parse and insert to database
        $parserClassName = sprintf('App\\Classes\\TicketParser\\%sTicketParser', $conference->class_name);
        $parser = new $parserClassName($conference);
        $results = $parser->save($records);
        // TODO Add filename to results array
        //debug($results);

        return $results;
    }
}

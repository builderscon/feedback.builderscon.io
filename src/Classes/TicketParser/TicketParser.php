<?php
namespace App\Classes\TicketParser;

class TicketParser
{
    protected $conference;

    public function __construct($conference)
    {
        $this->conference = $conference;
    }

    public function normalizeTwitter($string)
    {
        if (strpos($string, ' / ') !== false){
            // Use last line when multiline
            $lines = explode(" / ", $string);
            $string = array_pop($lines);
        }
        $string = str_replace('https://', '', $string);
        $string = str_replace('http://', '', $string);
        $string = str_replace('mobile.twitter.com/', '', $string);
        $string = str_replace('twitter.com/', '', $string);
        if (substr($string, 0, 1) === '@'){
            $string = substr($string, 1);
        }
        if (substr($string, -1, 1) === '/'){
            $string = substr($string, 0, -1);
        }

        return $string;
    }

    public function normalizeFacebook($string)
    {
        // Error if string contains space
        if (strpos($string, ' ') !== false){
            return null;
        }

        $matches = null;
        if (preg_match('@(?:https?://)?(?:www\.)?(?:facebook\.com/)?(?:[^/]+/)*([^/]+)/?@', $string, $matches) === 1){
            $account = $matches[1];

            // Error if account contains '?'
            if (strpos($account, '?') !== false){
                return null;
            }

            return $account;
        }

        return null;
    }

    public function normalizeGithub($string)
    {
        if (substr($string, 0, 1) === '@'){
            return substr($string, 1);
        }

        // ocm > com
        $string = str_replace('github.ocm', 'github.com', $string);

        $matches = null;
        if (preg_match('@(?:https?://)?(?:github\.com/)?([^/]+)/?@i', $string, $matches) === 1){
            $account = $matches[1];

            return $account;
        }

        return null;
    }
}

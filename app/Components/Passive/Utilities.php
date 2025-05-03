<?php

namespace App\Components\Passive;

class Utilities
{

    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function limitCharacters($text, $limit) 
    {
        if (strlen($text) > $limit) {
           $text = substr($text, 0, $limit) . '...';
        }

        return $text;
    }

    public static function getDomainFromEmail($email) {
        // Regular expression to match the domain part of the email
        $domainRegex = '/@(.+)$/';
    
        // Use the regular expression to extract the domain from the email
        preg_match($domainRegex, $email, $matches);
    
        // Check if a match was found
        if (isset($matches[1])) {
            return $matches[1]; // The extracted domain
        } else {
            return null; // Invalid email format or no domain found
        }
    }

    public static function formatURL($str)
    {
        $data = parse_url($str);

        if (!isset($data['scheme']) && !empty($str)) {
            return "https://{$str}";
        }

        return $str;
    }

    public static function getFileExtension($fileName)
    {
        return pathinfo($fileName, PATHINFO_EXTENSION);
    }
}

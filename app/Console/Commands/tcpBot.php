<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use \CodeWizz\RedditAPI\RedditAPI;
use App\Notifications\PushJobs;

use App\Job;
use Notification;
use App\User;


class tcpBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:tcpBot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $irc = new IRC();
        $colors = $irc->colors();

        $reddit = new RedditAPI("taodev91", "8fJUWB3exETiW78", "z6U6lida0GFEzacynDcllw", "a_7heyaSC04o9HoYK_5gTweI30tYmg", "https://www.reddit.com", "https://oauth.reddit.com", "STD");
        //fetch top Reddit posts
        $hot = $reddit->getHot("forhire+jobs4bitcoins", 100, false, false);
        foreach($hot->data->children as $link) {
            $link = $link->data;
            $title = $link->title;
            $href = $link->permalink;
            $body = $link->selftext_html;
            $plain_body = $link->selftext;
            $author = $link->author;
            
            /* if link text doesnt contain word hiring then skip it */
            if(!strstr(strtolower($title), "hiring")) continue;
            $new = true; /* Got a new link */

            /* Check if link already exists in database */
            $exists = Job::where("href", "=", $href)->first();
            if($exists) continue;

            /* CLI Output */
            echo $title."\n";
            echo $href."\n\n";

            /* Insert Link into Database */
            $job = new Job;
            $job->post_title = $title;
            $job->post_body = "$body";
            $job->post_author = $author;
            $job->href = $href;
            $job->flair_text = "";//$flair_text;
            $job->post_body_plain = $plain_body;
            $job->status = "";
            $job->subreddit = $link->subreddit;
            $job->save();

            /* Send out notifications for web browser / android */
            Notification::send(User::all(),new PushJobs([
                "job_id"=>$job->id,
                "title"=>$job->post_title,
                "body" => $job->post_body_plain,
                "icon" => "https://codebuilder.us/images/mandala4_75.png"
            ]));

            echo "Sent Notification.";

            $cmd = "ASLkjda*s@ !yQgCRtXrhmRNbyRMiV:subtlefu.ge https://jobbit.codebuilder.us/job/message/".$job->id;
            $fp = fsockopen("tcp://subtlefu.ge", 1337, $errno, $errstr, 30);
            if(!$cmd) return "no command given...";
            if(!$fp)  return "conn. refused";
                    
            $response = "";
            fwrite($fp, $cmd);
            //while (!feof($fp)) {
            //        $response .= fgets($fp, 128);
            //}
            fclose($fp);

            /* Send new messages to IRC Bot via Redis 
            $ircMsg = "[".$colors->purple."Job".$colors->nc."] ". $title." https://reddit.com".$href;
            $queue = Redis::get('TcpIRCQue');
            $queue = json_decode(($queue));
            if(is_array($queue)) $queue[] = $ircMsg;
                else $queue = [$ircMsg];
            Redis::set("TcpIRCQue", json_encode($queue));*/

        }


die();


        $new = 0; $count = 0;
        $filename = "/var/irc/phappr/storage/app/last_post.db";
        $last_post_text = file_get_contents ($filename);
        $irc = new IRC();
        $colors = $irc->colors();
        $url = "https://old.reddit.com/r/forhire+jobbit+jobs4bitcoins/new";
        $html = file_get_contents($url);

        /* Download HTML from job multi-sub-reddit ordered by new and parse and loop each link */
        $SelectorDOM = new SelectorDOM;
        $dom = $SelectorDOM->SelectDom($html);
        $links = $SelectorDOM->select('p.title');
        foreach($links as $link) {
            $count++;
            $title = $link["text"];
            $href = $link["children"][0]["attributes"]["href"];
            $full_link = "https://reddit.com".$href;


            echo $title."\n";
            echo $full_link."\n";
            /* if link text doesnt contain word hiring then skip it */
            if(!strstr(strtolower($title), "hiring")) continue;
            $new = true; /* Got a new link */
            
            file_put_contents($filename, $title);
            $ircMsg = "[".$colors->purple."Job".$colors->nc."] ". $title." ".$full_link;
            break;
        }
        echo "Parsed $count links and found $new new. \n\n";

        /* if got new link then update redis variable so that irc bot catches it and relays message into IRC */
        if(isset($ircMsg)) {
            $queue = Redis::get('TcpIRCQue');
            $queue = json_decode(($queue));
            if(is_array($queue)) $queue[] = $ircMsg;
                else $queue = [$ircMsg];
            Redis::set("TcpIRCQue", json_encode($queue));
        }
    }
}








/* IRC Notification Bot Connector Class */
class IRC {
    public function colors() {  //this function will take color as text and then output the proper IRC color codes
        $this->nc = "0";
        $this->blue = "2";
        $this->green = "3";
        $this->lightred = "4";
        $this->red = "5";
        $this->purple = "6";
        $this->orange = "7";
        $this->yellow = "8";
        $this->lightgreen = "11";
        $this->lightblue = "12";
        $this->lightpurple = "13";
        $this->grey = "14";
        $this->lightgrey = "15";
        $this->darkwhite = "16";
        return $this;
   }


}

/* HTML Selector Class */

// --- Selector.inc - (c) Copyright TJ Holowaychuk <tj@vision-media.ca> MIT Licensed
define('SELECTOR_VERSION', '1.1.6');
/**
 * SelectorDOM.
 *
 * Persitant object for selecting elements.
 *
 *   $dom = new SelectorDOM($html);
 *   $links = $dom->select('a');
 *   $list_links = $dom->select('ul li a');
 *
 */
class SelectorDOM {
  public function SelectDOM($data) {
    if ($data instanceof \DOMDocument) {
        $this->xpath = new \DOMXpath($data);
    } else {
        $dom = new \DOMDocument();
        @$dom->loadHTML($data);
        $this->xpath = new \DOMXpath($dom);
    }
  }
  
  public function select($selector, $as_array = true) {
    $elements = $this->xpath->evaluate(selector_to_xpath($selector));
    return $as_array ? elements_to_array($elements) : $elements;
  }
}
/**
 * Select elements from $html using the css $selector.
 * When $as_array is true elements and their children will
 * be converted to array's containing the following keys (defaults to true):
 *
 *  - name : element name
 *  - text : element text
 *  - children : array of children elements
 *  - attributes : attributes array
 *
 * Otherwise regular DOMElement's will be returned.
 */
function select_elements($selector, $html, $as_array = true) {
  $dom = new SelectorDOM($html);
  return $dom->select($selector, $as_array);
}
/**
 * Convert $elements to an array.
 */
function elements_to_array($elements) {
  $array = array();
  for ($i = 0, $length = $elements->length; $i < $length; ++$i)
    if ($elements->item($i)->nodeType == XML_ELEMENT_NODE)
      array_push($array, element_to_array($elements->item($i)));
  return $array;
}
/**
 * Convert $element to an array.
 */
function element_to_array($element) {
  $array = array(
    'name' => $element->nodeName,
    'attributes' => array(),
    'text' => $element->textContent,
    'children' =>elements_to_array($element->childNodes)
    );
  if ($element->attributes->length)
    foreach($element->attributes as $key => $attr)
      $array['attributes'][$key] = $attr->value;
  return $array;
}
/**
 * Convert $selector into an XPath string.
 */
function selector_to_xpath($selector) {
    // remove spaces around operators
    $selector = preg_replace('/\s*>\s*/', '>', $selector);
    $selector = preg_replace('/\s*~\s*/', '~', $selector);
    $selector = preg_replace('/\s*\+\s*/', '+', $selector);
    $selector = preg_replace('/\s*,\s*/', ',', $selector);
    $selectors = preg_split('/\s+(?![^\[]+\])/', $selector);
    foreach ($selectors as &$selector) {
        // ,
        $selector = preg_replace('/,/', '|descendant-or-self::', $selector);
        // input:checked, :disabled, etc.
        $selector = preg_replace('/(.+)?:(checked|disabled|required|autofocus)/', '\1[@\2="\2"]', $selector);
        // input:autocomplete, :autocomplete
        $selector = preg_replace('/(.+)?:(autocomplete)/', '\1[@\2="on"]', $selector);
        // input:button, input:submit, etc.
        $selector = preg_replace('/:(text|password|checkbox|radio|button|submit|reset|file|hidden|image|datetime|datetime-local|date|month|time|week|number|range|email|url|search|tel|color)/', 'input[@type="\1"]', $selector);
        // foo[id]
        $selector = preg_replace('/(\w+)\[([_\w-]+[_\w\d-]*)\]/', '\1[@\2]', $selector);
        // [id]
        $selector = preg_replace('/\[([_\w-]+[_\w\d-]*)\]/', '*[@\1]', $selector);
        // foo[id=foo]
        $selector = preg_replace('/\[([_\w-]+[_\w\d-]*)=[\'"]?(.*?)[\'"]?\]/', '[@\1="\2"]', $selector);
        // [id=foo]
        $selector = preg_replace('/^\[/', '*[', $selector);
        // div#foo
        $selector = preg_replace('/([_\w-]+[_\w\d-]*)\#([_\w-]+[_\w\d-]*)/', '\1[@id="\2"]', $selector);
        // #foo
        $selector = preg_replace('/\#([_\w-]+[_\w\d-]*)/', '*[@id="\1"]', $selector);
        // div.foo
        $selector = preg_replace('/([_\w-]+[_\w\d-]*)\.([_\w-]+[_\w\d-]*)/', '\1[contains(concat(" ",@class," ")," \2 ")]', $selector);
        // .foo
        $selector = preg_replace('/\.([_\w-]+[_\w\d-]*)/', '*[contains(concat(" ",@class," ")," \1 ")]', $selector);
        // div:first-child
        $selector = preg_replace('/([_\w-]+[_\w\d-]*):first-child/', '*/\1[position()=1]', $selector);
        // div:last-child
        $selector = preg_replace('/([_\w-]+[_\w\d-]*):last-child/', '*/\1[position()=last()]', $selector);
        // :first-child
        $selector = str_replace(':first-child', '*/*[position()=1]', $selector);
        // :last-child
        $selector = str_replace(':last-child', '*/*[position()=last()]', $selector);
        // :nth-last-child
        $selector = preg_replace('/:nth-last-child\((\d+)\)/', '[position()=(last() - (\1 - 1))]', $selector);
        // div:nth-child
        $selector = preg_replace('/([_\w-]+[_\w\d-]*):nth-child\((\d+)\)/', '*/*[position()=\2 and self::\1]', $selector);
        // :nth-child
        $selector = preg_replace('/:nth-child\((\d+)\)/', '*/*[position()=\1]', $selector);
        // :contains(Foo)
        $selector = preg_replace('/([_\w-]+[_\w\d-]*):contains\((.*?)\)/', '\1[contains(string(.),"\2")]', $selector);
        // >
        $selector = preg_replace('/>/', '/', $selector);
        // ~
        $selector = preg_replace('/~/', '/following-sibling::', $selector);
        // +
        $selector = preg_replace('/\+([_\w-]+[_\w\d-]*)/', '/following-sibling::\1[position()=1]', $selector);
        $selector = str_replace(']*', ']', $selector);
        $selector = str_replace(']/*', ']', $selector);
    }
    // ' '
    $selector = implode('/descendant::', $selectors);
    $selector = 'descendant-or-self::' . $selector;
    // :scope
    $selector = preg_replace('/(((\|)?descendant-or-self::):scope)/', '.\3', $selector);
    // $element
    $sub_selectors = explode(',', $selector);
    foreach ($sub_selectors as $key => $sub_selector) {
        $parts = explode('$', $sub_selector);
        $sub_selector = array_shift($parts);
        if (count($parts) && preg_match_all('/((?:[^\/]*\/?\/?)|$)/', $parts[0], $matches)) {
            $results = $matches[0];
            $results[] = str_repeat('/..', count($results) - 2);
            $sub_selector .= implode('', $results);
        }
        $sub_selectors[$key] = $sub_selector;
    }
    $selector = implode(',', $sub_selectors);
    
    return $selector;
}
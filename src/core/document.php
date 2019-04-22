<?php
namespace Ziki\Core;

use Mni\FrontYAML\Parser;
use KzykHys\FrontMatter\FrontMatter;
use Symfony\Component\Finder\Finder;
//use Item';
//use Ziki\Core\Feed';
//use Ziki\Core\RSS2';
use Parsedown;
/**
 *	The Document class holds all properties and methods of a single page document.
 *
 */

class Document{
    //define an instance of the symfony clss
    //define an instance of the frontMatter class

    protected $file;

    public function __construct($file) {
        $this->file       = $file;
    }

    public function file()
    {
        return $this->file;
    }

    //for creating markdown files
    public function create($content){
        // Write md file
        $document = FrontMatter::parse($content);
        $md = new Parser();
        $markdown = $md->parse($document);
        $yaml = $markdown->getYAML();
        $html = $markdown->getContent();
        $doc = FileSystem::write($this->file, $yaml."\n".$html);
        if ($doc) {
            $result = array("error" => false, "message" => "Post published successfully");
        }
        else{
            $result = array("error" => true, "message" => "Fail while publishing, please try again");
        }
        return $doc;
    }
    //get post
    public function get(){
        $finder = new Finder();
        // find all files in the current directory
        $finder->files()->in($this->file);
        $posts = [];
        if($finder->hasResults()){
            foreach($finder as $file){
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                //$document = FileSystem::read($this->file);
                $parsedown  = new Parsedown();
                $title = $parsedown->text($yaml['title']);
                $bd = $parsedown->text($body);
                $time = $parsedown->text($yaml['timestamp']);
                $url = $parsedown->text($yaml['post_dir']);
                $content['title'] = $title;
                $content['body'] = $bd;
                $content['url'] = $url;
                $content['timestamp'] = $time;
                array_push($posts, $content);
            }
            return $posts;
        }
        else{
            return false;
        }
    }
    public function getRSS(){
      date_default_timezone_set('UTC');
$Feed = new RSS2;
// Setting some basic channel elements. These three elements are mandatory.
$Feed->setTitle('Elijah feeds');
$Feed->setLink('https://github.com/mibe/FeedWriter');
$Feed->setDescription('feeds below.');

// Image title and link must match with the 'title' and 'link' channel elements for RSS 2.0,
// which were set above.
$Feed->setImage('ing & Checking the Feed Writer project', 'https://github.com/mibe/FeedWriter', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Rss-feed.svg/256px-Rss-feed.svg.png');

// Use core setChannelElement() function for other optional channel elements.
// See http://www.rssboard.org/rss-specification#optionalChannelElements
// for other optional channel elements. Here the language code for American English and
$Feed->setChannelElement('language', 'en-US');

// The date when this feed was lastly updated. The publication date is also set.
$Feed->setDate(date(DATE_RSS, time()));
$Feed->setChannelElement('pubDate', date(\DATE_RSS, strtotime('2013-04-06')));


$Feed->setSelfLink('http://example.com/myfeed');
$Feed->setAtomLink('http://pubsubhubbub.appspot.com', 'hub');

$Feed->addNamespace('creativeCommons', 'http://backend.userland.com/creativeCommonsRssModule');
$Feed->setChannelElement('creativeCommons:license', 'http://www.creativecommons.org/licenses/by/1.0');

$Feed->addGenerator();

        $finder = new Finder();
        $finder->files()->in($this->file);

        if($finder->hasResults()){
            foreach($finder as $file){
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                $parsedown  = new Parsedown();
                $title = $parsedown->text($yaml['title']);
                $bd = $parsedown->text($body);
                $time = $parsedown->text($yaml['timestamp']);
                $url = $parsedown->text($yaml['post_dir']);

                $newItem = $Feed->createNewItem();
                $newItem->setTitle($title);
                $newItem->setLink('http://www.example.com');
                $newItem->setDescription(substr($bd,0,100));
                $newItem->setDate('2013-04-07 00:50:30');

                $newItem->setAuthor('elijah okokon', 'okoelijah@gmail.com');

                $newItem->setId('http://example.com/URL/to/article', true);

                $newItem->addElement('source', 'Mike\'s page', array('url' => 'http://www.example.com'));


                $Feed->addItem($newItem);

            }
          $myFeed = $Feed->generateFeed();
            // If you want to send the feed directly to the browser, use the printFeed() method.
          return $Feed->printFeed();

        }
        else{
            return false;
        }
    }
    //update post
    public function update(){

    }
    //deletepost
    public function delete(){

    }

}

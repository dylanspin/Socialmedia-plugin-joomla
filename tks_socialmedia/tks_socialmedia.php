<?php

/**
 * @author     Dylan spin,
 */

defined('_JEXEC') or die;
jimport('joomla.plugin.plugin');

class PlgSystemtks_Socialmedia extends JPlugin{

    protected $app;
    public $params;

    function __construct(&$subject, $config) {
        parent :: __construct($subject, $config);
    }

    public function createCon($pluginParams){

	    $insta = $pluginParams->get('insta');
	    $facebook = $pluginParams->get('face');
	    $twitter = $pluginParams->get('twit');
	    $linkedin = $pluginParams->get('link');
      	$tell = $pluginParams->get('tel');
    	$text = $pluginParams->get('text');

    	if($tell[0] == "0"){
    		$tell = substr_replace($tell,'31',0,1);
		}

    	$urls = [$insta,$facebook,$twitter,$linkedin];

	    $cont = "";
		$a = ["<a class='insta' href='$urls[0]'><i class='fa fa-instagram'></i></a>",
			  "<a class='facebook' href='$urls[1]'><i class='fa fa-facebook-f'></i></a>",
			  "<a class='twitter' href='$urls[2]'><i class='fa fa-twitter'></i></a>",
			  "<a class='linkedin' href='$urls[3]'><i class='fa fa-linkedin'></i></a>"];

	 	for($i=0; $i<count($urls); $i++){
		  	if(strlen($urls[$i]) > 0){
		  		$cont .= $a[$i];
		  	}
	  	}

	  	$cont .= "<a class ='whatsapp' href='https://api.whatsapp.com/send?phone=$tell&text=$text' target='_blank'><i class='fa fa-whatsapp'></i></a>";

	  	return "<div class='socialmedia_vak'>".$cont."</div>";

  	}
    public function onAfterDispatch(){

        $plugin = JPluginHelper::getPlugin('system', 'tks_socialmedia');
        $pluginParams = new JRegistry($plugin->params);

        $font = $pluginParams->get('font');

        $plgURL = JURI::base() . 'plugins/system/tks_socialmedia/css';
        $doc = JFactory::getDocument();

        $doc->addStyleSheet($plgURL . '/style.css');

    	$css = ".insta , .twitter , .facebook , .linkedin {
					font-size:".$font."px;
				}";

        $doc->addStyleDeclaration($css);
        $this->params = $pluginParams;
    }

    public function onAfterRender(){

        $getapp = JFactory::getApplication();
        if ($getapp->isAdmin()) {
            return false;
        }

        $pluginParams = $this->params;

        $body = $this->app->getBody();
        $content = $this->createCon($pluginParams);

        $body = str_replace('</body>', $content . '</body>', $body );

        $this->app->setBody($body);
    }
}

?>

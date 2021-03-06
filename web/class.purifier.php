<?php
   require_once('htmlpurifier-3.0.0/library/HTMLPurifier.auto.php');
   
   class Sanitize
   {
      
      /***
       * @return filtered data based on rules defined in the function
       * @param $content String
       */
      public function filter($content) {
         $content = stripslashes($content);
         $config = HTMLPurifier_Config::createDefault();
         
         $config->set('HTML', 'DefinitionID', 'content');
         $config->set('HTML', 'DefinitionRev', 1);
         $def =& $config->getHTMLDefinition(true);
         $def->addAttribute('a', 'target', 'Enum#_blank,_self,_target,_top');
   
         $purifier = new HTMLPurifier($config);
         $clean_html = $purifier->purify($content);
         return $clean_html;
      }
      
      /***
       * @return encoded data
       * @param $content String
       */
      public function htmlEncode($content) {
         return htmlentities($content, ENT_QUOTES, 'UTF-8');
      }
      
      /***
       * @return decoded data
       * @param $content String
       */
      public function htmlDecode($content)
      {
         return html_entity_decode($content, ENT_QUOTES, 'UTF-8');
      }
      
      /***
       * @return data stripped of tags
       * @param $content String
       */
      public function stripTags($content)
      {
         return strip_tags($content);
      }
      
      /***
       * @return data stripped of tags and encoded
       * @param $content String
       */
      public function stripTagsEncode($content)
      {
         return $this->htmlEncode(strip_tags($content));
      }
      
      /***
       * @return data stripped of tags/attributes
       * @param $content String
       * @param $aAllowedTags Array
       * @param $aDisabledAttributes Array
       */
      public function stripTagsAttributes($content, $aAllowedTags = array(), $aDisabledAttributes = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'))
      {
         if (empty($aDisabledAttributes))
         {
            return strip_tags($content, implode('', $aAllowedTags));
         }
         
         return preg_replace('/<(.*?)>/ie', "'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $aDisabledAttributes) . ")[ \\t\\n]*=[ \\t\\n]*[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", strip_tags($content, implode('', $aAllowedTags)));
      }
      
      /***
       * @return data with slashes striped
       * @param $data
       */
      public function stripSlashes($data) {
         return stripslashes($data);
      }
      
      /***
       * @return data with slashes added
       * @param $data
       */
      public function addSlashes($data) {
         return addslashes($data);
      }
            
   }
   
?>
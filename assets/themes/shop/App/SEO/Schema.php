<?php

namespace App\Seo;

final class Schema
{
   public function __construct()
   {
   }

   public static function getSchemaOrganisation()
   {
      return '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Organization","name":"' . get_bloginfo('name') . '","url":" ' . get_home_url() . ' ","logo":"' . wp_get_attachment_url(get_field('site_logo', 'options')) . '"}</script>';
   }

   public static function getSchemaHowTo()
   {
      if (has_block('acf/how-to')) {
         $blocks = parse_blocks(get_the_content());
         foreach ($blocks as $block) {
            if ($block['blockName'] === 'acf/how-to') {
               $cards_lengs = $block['attrs']['data']['cards_how_to'];
               $schema = '';
               if ($cards_lengs) {
                  $schema .= '<script type="application/ld+json">{"@context":"https://schema.org","@type":"HowTo","name":"How To ' . get_the_title() . '", "totalTime": "PT3M", "supply": [{"@type": "HowToSupply","name": "internet"}], "tool": [{"@type": "HowToTool","name": "celular"},{"@type": "HowToTool","name": "notebook"}], "step":[';
                  for ($i = 1; $i <= $cards_lengs; $i++) {
                     $name = $block['attrs']['data']['cards_how_to_' . ($i - 1) . '_title'];
                     $desc = htmlspecialchars(strip_tags($block['attrs']['data']['cards_how_to_' . ($i - 1) . '_description']));
                     $image = wp_get_attachment_url($block['attrs']['data']['cards_how_to_' . ($i - 1) . '_image']);
                     $schema .= '{"@type":"HowToStep","name":"' . $name . '","text":"' . $desc . '", "image": "' . $image . '","url":"' . get_home_url() . '"}';
                     $schema .= ($cards_lengs != $i) ? ',' : '';
                  }
                  $schema .= ']}</script>';

                  return $schema;
               }
            }
         }
      }

      return '';
   }

   public static function getSchemaFaq()
   {
      if (has_block('acf/faq')) {
         $blocks = parse_blocks(get_the_content());
         foreach ($blocks as $block) {
            if ($block['blockName'] === 'acf/faq') {
               $cards_lengs = $block['attrs']['data']['faq'];
               $schema = '';
               if ($cards_lengs) {

                  $schema .= '<script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","inLanguage":"en","dateCreated":"' . get_the_modified_date('Y-m-d H:i:s') . '","datePublished":"' . get_the_modified_date('Y-m-d H:i:s') . '","dateModified":"' . get_the_modified_date('Y-m-d H:i:s') . '","name":"' . get_the_title() . '","mainEntity":[';
                  for ($i = 1; $i <= $cards_lengs; $i++) {
                     $name = $block['attrs']['data']['faq_' . ($i - 1) . '_question'];
                     $desc = htmlspecialchars(strip_tags($block['attrs']['data']['faq_' . ($i - 1) . '_answer']));

                     $schema .= '{"@type":"Question","position":' . $i . ',"name":"' . $name . '","answerCount":' . $i . ',"acceptedAnswer":{"@type":"Answer","text":"' . $desc . '","dateCreated":"' . get_the_modified_date('Y-m-d H:i:s') . '","datePublished":" ' . get_the_modified_date('Y-m-d H:i:s') . '","dateModified":"' . get_the_modified_date('Y-m-d H:i:s') . '"}}';
                     $schema .= ($cards_lengs != $i) ? ',' : '';
                  }
                  $schema .= ']}</script>';

                  return $schema;
               }
            }
         }
      }
      return '';
   }
}

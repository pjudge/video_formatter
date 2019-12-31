<?php

namespace Drupal\video_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'video thumbnail' formatter.
 *
 * @FieldFormatter(
 *   id = "video_thumbnail",
 *   label = @Translation("Video Thumbnail"),
 *   description = @Translation("Video Thumbnail"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class VideoThumbnailFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    
    $elements = [];
    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      // This gets the value of the Video URL field from the media video.
      $url = $entity->get('field_media_oembed_video')->value;

      // We can use regex to strip the video ID out of the URL. 
      if (preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches)) {
        $video_url = $matches[1];

        // This gets the thumbnail URI and turns it into the full, usable URL.   
        $thumb_uri = $entity->get('thumbnail')->entity->getFileUri();
        $thumb_path = Url::fromUri(file_create_url($thumb_uri))->toString();

        // This gets the video title, needed for accessbility. 
        $video_title = $entity->get('name')->value;
        
        $elements[$delta] = [
          '#theme' => 'video_formatter',
          '#url' => $video_url,
          '#thumbnail' => $thumb_path,
          '#title' => $video_title,
          '#attached' => [
            'library' => [
              'video_formatter/video_formatter',
            ],
          ],
        ];
      }
    }
    return $elements;
  }

}

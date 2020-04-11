<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.04.2020
 * Time: 12:07
 */

 if(is_array($items) && count($items)):?>

     <div class="content_block catalog_menu">
         <div class="content_block_header">
             <span class="content_block_title">Каталог</span>
         </div>
         <div class="content_block_content">
             <ul class="editor-sort level_1" data-template-path="pages.iditem._parameter.sort">
                 <?php foreach($items as $item):?>
                 <li data-iditem="<?=$item['id']?>">
                     <?php if(strstr(Yii::$app->request->url,$item['url']) !== false):?>
                        <span><?=$item['name']?></span>
                     <?php else: ?>
                         <a href="<?=$item['url']?>"><?=$item['name']?></a>
                     <?php endif; ?>

                     <?php if( strstr(Yii::$app->request->url,$item['url']) !== false && isset($item['_subcatalogs']) && is_array($item['_subcatalogs']) && count($item['_subcatalogs'])):?>
                     <div class="level_2">
                         <ul class="editor-sort" data-template-path="pages.iditem._parameter.sort">
                             <?php foreach($item['_subcatalogs'] as $subitem):?>

                                 <li data-iditem="<?=$subitem['id']?>">
                                     <?php if(strstr(Yii::$app->request->url,$subitem['url']) !== false):?>
                                         <span><?=$subitem['name']?></span>
                                     <?php else: ?>
                                         <a href="<?=$subitem['url']?>"><?=$subitem['name']?></a>
                                     <?php endif; ?>
                                 </li>
                             <?php endforeach; ?>
                         </ul>
                     </div>
                     <?php endif; ?>

                 </li>
                 <?php endforeach; ?>
             </ul>
         </div>
     </div>

 <?php endif; ?>

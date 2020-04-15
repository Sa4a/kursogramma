<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.04.2020
 * Time: 12:07
 */

if (is_array($params) && count($params)):?>
    <div class="row">
            <div class="col-md-6 text-center">
                <a href="<?=$params['left_url']['relation_value']?>">
                    <img class="media-object" height="250" width="100%" src="http://ishop33.catalog.prodamus.me/<?=$params['left_banner']['relation_value']?>" alt="...">
                    <p>
                        <?=$params['left_title']['relation_value']?>
                    </p>
                </a>
            </div>
        <div class="col-md-6 text-center">
            <a href="<?=$params['right_url']['relation_value']?>">
                <img class="media-object" height="250" width="100%" src="http://ishop33.catalog.prodamus.me/<?=$params['right_banner']['relation_value']?>" alt="...">
                <p>
                    <?=$params['right_title']['relation_value']?>
                </p>
            </a>
        </div>
    </div>


<?php endif; ?>

<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.04.2020
 * Time: 12:07
 */

if (is_array($products) && count($products)):?>
    <h1><?= $name ?></h1>
    <div class="row">


        <?php foreach ($products as $item): ?>
            <div class="card-deck col-md-4 text-center">
                <div class="card col-mb-4 shadow-sm">

                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal"><?= $item['product_name'] ?></h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title"><?= $item['product_price_customer'] ?>
                            <small class="text-muted">Руб.</small>
                        </h1>
                        <img src="<?= $item['_parameter']['photo_urls']['parameter_value'] ?>" width="100"/>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>Бренд <?= $item['_parameter']['brand']['parameter_value'] ?></li>
                            <li>Тип <?= $item['_parameter']['type']['parameter_value'] ?></li>
                        </ul>
                        <button type="button" class="btn btn-lg btn-block btn-outline-primary">Купить</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>


    </div>


<?php endif; ?>

<div class="recommended-items col-lg-12 col-sm-12 col-xs-12 col-md-12">
    <h2 class="title text-center">Рекомендуемые товары</h2>
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            % php $isLoop = false %
            % loop $data as $t%
            <div class="%% $isLoop ? 'item' : 'item active' %%">
                % loop $t as $i %
                <div class="col-sm-4">
                    <div class="product-image-wrapper thumbnail">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="http://graph.digiseller.ru/img.ashx?maxlength=98&amp;id_d=%% $i->id_goods %%" alt="%% $i->name_goods %%" class="img-preview">
                                <h3 class="goods-name">%% $i->name_goods %%</h3>
                                <p class="price">%% $i->price %% %% Registry::get('curr-symbol') %%</p>
                                <a href="/goods/%% $i->id_goods %%" class="btn btn-default">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
                % endloop %
            </div>
            % php $isLoop = true %
            % endloop %
        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>
<div class="col-md-3 col-sm-4 col-xs-6 masonry__item" data-masonry-filter="<?php echo $CategoryName ?>">
                        <div class="modal-instance">
                        <a href="#">
                            <div class="shop-item shop-item-1 modal-trigger">
                                <div class="shop-item__price hover--reveal">
                                    <span></span>
                                </div>
                                <div class="shop-item__image">
                                    <div class="shop-image-container">
                                        <img alt="product" src="<?php echo     $Thumbnail?>" class="show-item-image" />
                                    </div>
                                </div>
                                <div class="shop-item__title">
                                    <h5><?php echo $ProductName ?></h5>
                                </div>
                            </div>
                        </a>
                        <div class="modal-container">
                                    <div class="modal-content height--natural">
                                        <div class="card card-1">
                                            <div class="card__image">
                                                <div class="slider" data-paging="true">
                                                    <ul class="slides">
							<?php 
							foreach($ProductImage[$productid] as $key => $path){
							?>
                                                        <li>
                                                            <img alt="Pic" data-src="<?php echo $path ?>" />
                                                        </li>
							<?php
							}
							?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card__body boxed bg--white">
                                                <div class="card__title">
                                                    <h5 title="<?php echo $ProductName?>" style="width:190px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo $ProductName ?></h5>
                                                </div>
                                                <p style="text-align:justify">
                                                   <?php echo $Description ?> 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end of modal-content-->
                                </div>
                                <!--end of modal-container-->
                        </div>
                    </div>



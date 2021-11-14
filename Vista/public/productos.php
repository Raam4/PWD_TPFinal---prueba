<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
include_once("../estructura/header.php");
?>

<div class="content-wrapper">
        <div id="myCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
            </div>
            <div class="carousel-inner">
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"></rect></svg>

                <div class="container">
                <div class="carousel-caption text-start">
                    <h1>Example headline.</h1>
                    <p>Some representative placeholder content for the first slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
                </div>
                </div>
            </div>
            <div class="carousel-item active">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"></rect></svg>

                <div class="container">
                <div class="carousel-caption">
                    <h1>Another example headline.</h1>
                    <p>Some representative placeholder content for the second slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"></rect></svg>

                <div class="container">
                <div class="carousel-caption text-end">
                    <h1>One more for good measure.</h1>
                    <p>Some representative placeholder content for the third slide of this carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
                </div>
                </div>
            </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
        </div>
    
    <div class="row ms-1">
        <div class="col-md-3">
            <div class="card sticky-top">
                <div class="card-body">
                    <div id='filtros'>
                        <h3>Filtros</h3>
                        <div class="form-group">
                        <?php
                            $abmrubro = new AbmRubro();
                            foreach($abmrubro->buscar(array()) as $rubro){
                                $desc = $rubro['runombre'];
                        ?>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-danger" type="checkbox" value="<?php echo $rubro['idrubro'];?>" id="<?php echo $desc;?>" checked>
                                <label for="<?php echo $desc;?>" class="custom-control-label"><?php echo $desc;?></label>
                            </div>
                        <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row" id="filaProd">
            </div>
        </div>
    </div>
</div>
<script>
    $('#filtros').ready(function(){
        $('input[type=checkbox]').each(function(){
            if($(this).is(':checked')){
                var self = $(this);
                var select = '#rub'+self.val();
                $.ajax({
                        method: 'POST',
                        url: '../accion/accionProducto.php',
                        data: {'idrubro' : self.val()},
                        type: 'json',
                        success: function(ret) {
                            $('#filaProd').append(JSON.parse(ret));
                        },
                        error: function (ret) {
                        }
                });
            };
        });
    });

    $('#filtros').ready(function(){
        $('input[type=checkbox]').on('change', function() {
            var self = $(this);
            var select = '#rub'+self.val();
            if(!self.is(':checked')){
                $(select).each(function(){
                    $(this).remove();
                });
            }else{
                $.ajax({
                    method: 'POST',
                    url: '../accion/accionProducto.php',
                    data: {'idrubro' : self.val()},
                    type: 'json',
                    success: function(ret) {
                        $('#filaProd').append(JSON.parse(ret));
                    },
                    error: function (ret) {
                    }
                });
            }
        });
    });
</script>

<?php include_once("../estructura/footer.php"); ?>
<?php
require_once "dbconection/db.php";

$select = mysqli_query($con, "SELECT * FROM user");

if (isset($_POST['submit'])) {
    $email = $_POST['email'] ? $_POST['email'] : '';
    $title = $_POST['title'] ? $_POST['title'] : '';
    $brand = $_POST['brand'] ? $_POST['brand'] : '';
    $model = $_POST['Model'] ? $_POST['Model'] : '';
    $short_description = $_POST['short_description'] ? $_POST['short_description'] : '';
    $price = $_POST['price'] ? $_POST['price'] : '';
    $stock = $_POST['stock'] ? $_POST['stock'] : '';
    $characteristics = implode(',', $_POST['characteristics']);

    if (!empty($email) && !empty($title) && !empty($brand) && !empty($model) && !empty($short_description) && !empty($price) && !empty($stock) && !empty($characteristics)) {
        $image = $_FILES['img'];
        if (count($_FILES['img']['name']) < 2) {
            $image_req = "minmum 2 image required";
        }
        $ext = array("jpg", "jpeg", "png", "webp");
        $width = 1080;
        $height = 800;

        $file_tmp = $_FILES['img']['tmp_name'];
        foreach ($_FILES['img']['tmp_name'] as $file_tmp) {
            $wh = getimagesize($file_tmp);
            $img_width = $wh[0];
            $img_height = $wh[1];
        }


        if ($img_width < $width || $img_height < $height) {
            if (count($_FILES['img']['name']) >= 2) {
                
                for ($i = 0; $i < count($_FILES['img']['name']); $i++) {
                    $file_tmp = $_FILES['img']['tmp_name'][$i];
                    if ($_FILES['img']['size'][$i] > 204800) {
                        $max_err = "max 200kb Image uploaded <br>";
                    } else if ($_FILES['img']['size'][$i] < 204800) {

                        $rand = rand(1000000, 99999999);
                        $explode = explode(".", $image['name'][$i]);
                        $extension = end($explode);
                        if (in_array($extension, $ext)) {
                            $multiple_image[] = $rand . "." . $extension;
                            move_uploaded_file($image['tmp_name'][$i], "img/" . $multiple_image[$i]);
                        } else {
                            $arr = "Only JPG and PNG image required";
                        }
                    }
                }
                $img = implode(',', $multiple_image);

                if (isset($img) && !empty($img)) {
                    $sql = "INSERT INTO user(`email`,`title`,`Brand`,`Model`,`description`,`image`,`Price`,`Characteristics`,`InStock`)VALUES('$email','$title','$brand','$model','$short_description','$img','$price','$characteristics','$stock')";
                    $exc = mysqli_query($con, $sql);
                    if ($exc) {
                        $success = "data insert successfully";
                        header('location:index.php');
                    }
                }
            }
        } else {
            $max = "less them 1080X800 image";
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <form method="post" enctype="multipart/form-data" onsubmit="return StaticVal()">
        <div>
            <table>
                <h2>Mobail</h2>
                <tbody>
                    <tr>
                        <div>
                            <th class="table-heading">Email</th>
                            <td>
                                <input type="email" name="email" id="email"><br>
                                <span id="email_err" class="validation"></span>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div>
                            <th class="table-heading">Title</th>
                            <td>
                                <input type="text" name="title" id="title"><br>
                                <span id="title_err" class="validation"></span>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <th class="table-heading">Brand</th>
                        <td>
                            <select name="brand" id="brand">
                                <option value="">Select Brand</option>
                                <option value="Apple">Apple</option>
                                <option value="Samsung">Samsung</option>
                                <option value="oneplus">oneplus</option>
                            </select><br>
                            <span id="brand_err" class="validation"></span>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-heading">Model name:</th>
                        <td>
                            <input type="text" name="Model" id="Model" maxlength="20"><br>
                            <span id="model_err" class="validation"></span>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-heading">Short description</th>
                        <td>
                            <textarea id="short_description" name="short_description" rows="4" minlength="100" maxlength="200"></textarea><br>
                            <span id="short_err" class="validation"></span>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-heading">image:</th>
                        <td>
                            <input type="file" name="img[]" id="image" multiple><br>
                            <span id="image_err" class="validation">
                                <?php if (isset($image_req)) {
                                    echo $image_req;
                                }
                                if (isset($max_err)) {
                                    echo $max_err;
                                };
                                if (isset($arr)) {
                                    echo $arr;
                                }
                                if (isset($max)) {
                                    echo $max;
                                } ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-heading">Price:</th>
                        <td>
                            <input type="number" id="price" name="price" min="0"><br>
                            <span id="price_err" class="validation"></span>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-heading">Characteristics:</th>
                        <td>
                            <input type="checkbox" name="characteristics[]" id="Support" value="5G Support"> 5G Support
                            <br><input type="checkbox" name="characteristics[]" id="Waterproof" value="Waterproof"> Waterproof
                            <br><input type="checkbox" name="characteristics[]" id="Water" value="WaterResistance"> Water Resistance
                            <br><input type="checkbox" name="characteristics[]" id="Dust" value="DustProof"> Dust Proof
                            <br><input type="checkbox" name="characteristics[]" id="Curved" value="CurvedDisplay"> Curved Display
                            <br>
                            <span id="Char_err" class="validation"></span>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-heading">In Stock:</th>
                        <td>
                            <input type="radio" id="in_stock" name="stock" value="In Stock" checked>
                            <label>In Stock</label>

                            <input type="radio" id="out_of_stock" name="stock" value="Out of Stock">
                            <label>Out of Stock</label><br>
                            <span id="stock_err" class="validation"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <input type="submit" value="submit" name="submit" id="submit">
        </div>
        </div>
    </form>


    <section>
        <div class="filter-feilds">
            <div class="filter-box">
                <select name="filter" id="sort">
                    <option>select</option>
                    <option value="Price-Desc">Price_Desc</option>
                    <option value="Price-Asc">Price_Asc</option>
                    <option value="InStockFirst">In Stock First</option>
                    <option value="OutofStockFirst">Out of Stock First</option>
                    <option value="Brand-Asc">Brand_Asc</option>
                    <option value="Brand-Desc">Brand-Desc</option>
                </select>
            </div>

            <div class="search">
                <input type="text" placeholder="search" id="search" name="search">
                <button type="submit">submit</button>
            </div>
        </div>
        <div>
            <table class="record">
                <thead>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Stock</th>
                </thead>
                <tbody class="data-res">
                    <?php while ($data = mysqli_fetch_assoc($select)) { ?>
                        <?php $image = explode(',', $data['image']); ?>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td>
                                <?php for ($i = 0; $i < count($image); $i++) { ?>
                                    <img src="<?php echo 'img/' . $image[$i] ?>" width="50px" height="50px">
                                <?php } ?>
                            </td>
                            <td><?php echo $data['title']; ?></td>
                            <td><?php echo $data['Brand']; ?></td>
                            <td><?php echo $data['Model']; ?></td>
                            <td><?php echo $data['Price']; ?></td>
                            <td><?php echo $data['InStock']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js"></script>
</body>

</html>
<?php
require_once "incl/init.php";
$mode = filter_input(INPUT_POST, "mode", FILTER_SANITIZE_STRING);
if (empty($mode)) {$mode = filter_input(INPUT_GET, "mode", FILTER_SANITIZE_STRING);}
if (empty($mode)) {$mode = "list";}
$user = new User();
if ($user->isAdmin($_SESSION["userId"])) {
    
    switch (strtoupper($mode)) {
        default:
        case "LIST":
            require 'incl/header.php';
            $product = new Product();
            $columns = [
                "id" => "id",
                "name" => "Product Name",
                "description" => "Description",
                "options" => "Options",
            ];
            $products = [];
            foreach ($product->getAllProducts() as $value) {
                $value["options"] = htmltool::presentLinkIcon('?mode=delete&id=' . $value['id'], "delete") . htmltool::presentLinkIcon('?mode=edit&id=' . $value['id'], "edit");
                $products[] = $value;
            }
            $p = new listpresenter($columns, $products);
            echo $p->listTable();
            // var_dump($producuts)
            require 'incl/footer.php';
            break;
        case "DETAILS":
            break;
        case "EDIT":
            $id = isset($_GET["id"]) ? $_GET["id"] : 0;
            $product = new Product();
            if ($id) {
            $product->getProduct($id);
             }
            ?>
            <div class="container">
                <form class="form-horizontal" method="post">
                <input type="hidden" name="mode" value="save">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div class="form-group row">
                    <label for="" class="col-3">Navn</label>
                    <input type="" class="form-control col-9" name="name" placeholder="" value="<?php echo $product->name ?>">
                </div>
                <div class="form-group row">
                    <label for="" class="col-3">Description</label>
                    <textarea class="form-control" rows="10" name="description"><?php echo $product->description; ?></textarea>
                </div>
                <div class="form-group row">
                    <label for="" class="col-3">Description</label>
                    <textarea class="form-control" rows="10" name="description"><?php echo $product->image; ?></textarea>
                </div>
                <!-- <div class="form-group row">
                    <select name="" id="">
                        <?php
                            $sql = "SELECT * FROM gender";
                            $row = $db->_fetch_array($sql);
                            print_r($row);
                        ?>
                        <option value="<?php //echo $row["0"]["id"] ?>"><?php //echo $row["0"]["gender"] ?></option>
                        <option value="<?php //echo $row["1"]["id"] ?>"><?php //echo $row["1"]["gender"] ?></option>
                    </select>
                </div> -->
                <button type="submit" class="btn btn-primary">Gem</button>
                </form>
            </div>
            <?php
            break;
        case "SAVE":
            $product = new Product();
            $product->id = (int) $_POST["id"];
            $product->name = ($_POST["name"]);
            $product->description = ($_POST["description"]);
            $id = $product->save();
            // header("Location: ?mode=details&id=" . $id);
            header("Location: ?mode=LIST");
            break;
        
        case "DELETE":
            $id = (int) $_GET["id"];
            $user = new User();
            $user->deleteUser($id);
            header("location: index.php");
            break;
    }
}

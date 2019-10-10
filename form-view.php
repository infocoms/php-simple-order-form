
<?php
// define variables and set to empty values
$street = $email = $streetnumber = $city = $zip = "";
$streetErr = $emailErr = $streetnumberErr = $cityErr = $zipErr = "";
$errorLog = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["street"])) {
        echo $streetErr =  '<div class="alert alert-danger">
        Street name is required!</div>';
    } else {
        $street = test_input($_POST["street"]);
        $errorLog = $errorLog + 1;
    }

    if (empty($_POST["email"])) {
        echo $emailErr = '<div class="alert alert-danger">Email is required!</div>';
    } else {
        $email = $_POST["email"];
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo $emailErr = '<div class="alert alert-danger">Invalid email format!</div>';
        }
        else{
            $email = test_input($_POST["email"]);
            $errorLog = $errorLog + 1;
        }
    }

    if (empty($_POST["streetnumber"])||!is_numeric($_POST["streetnumber"])) {
        echo $streetnumberErr = '<div class="alert alert-danger">Street number is empty or invalid!</div>';
    } else {
        $streetnumber = test_input($_POST["streetnumber"]);
        $errorLog = $errorLog + 1;
    }

    if (empty($_POST["city"])) {
        echo $cityErr = '<div class="alert alert-danger">City is required!</div>';
    } else {
        $city = test_input($_POST["city"]);
        $errorLog = $errorLog + 1;
    }

    if (empty($_POST["zipcode"]) || !is_numeric($_POST["zipcode"])) {
        echo $zipErr = '<div class="alert alert-danger">Zipcode is empty or invalid!</div>';
    } else {
        $zip = test_input($_POST["zipcode"]);
        $errorLog = $errorLog + 1;
    }
}

$op1 = date('h:i a', time() + 7200);
$op2 = date('h:i a', time() + 2700);


if ($errorLog == 5){
    echo '<div class="alert alert-success">Order has been sent successfully!</div>';
    if ($_POST["delivery"] == 0){
        echo '<div class="alert alert-light" role="alert">'.'Expected delivery time '.$op1.' aprox 2 hours</div>';
    }else{
        echo '<div class="alert alert-light" role="alert">'.'Expected delivery time '.$op2.' aprox 45 Minutes</div>';
    }
}





function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php echo $email;?>"/>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php echo $street;?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?php echo $streetnumber;?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php echo $city;?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo $zip;?>">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
            <legend>Delivery Method</legend>
            <select  name="delivery" class="form-control col-md-6">
                <option value="0" selected>Standard Delivery via standard drone services</option>
                <option value="1">Express Delivery via express drone services</option>
            </select>
        </fieldset>



        <button type="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
    .alert{
        text-align: center;
        margin-bottom: 0;
    }
</style>
</body>
</html>
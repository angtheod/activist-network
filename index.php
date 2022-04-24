<?php
/**
 * Created by PhpStorm.
 * User: losangelos
 * Name: Angelos Theodorakopoulos
 * Email: angtheod@gmail.com
 * Date: 4/5/2017
 * Time: 11:56 πμ
 */

/*
 * We say that two activists who signed the same action have 1 degree of separation.
 * We say that two activists who each have 1 degree of separation with the same activist,
 * but who did not themselves sign the same action, have 2 degrees of separation.  Etc.
 *
 * Write a function that takes an activist as an argument, and that first prints out all activists
 * who have 1 degree of separation from that activist, then prints out all activists that have 2 degrees of separation (from that activist?),
 * then 3, etc.  It should never print the same activist twice.
 *
 * Implementation Design
 * ---------------------------
 * We will implement this by using a HashTable.
 * The HashTable has the activist name as key and the activist object as node.
 * Each node has _parent node (except for the root node) and possibly children nodes.
 * Tested with php 7.3
 */

namespace test1;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>
            Interview Test 1
        </title>

        <style>
            #headline {margin-top: 20px; font-weight: bold; text-decoration: underline; font-size: 120%;}
            #error {display: inline-block; color: #7793bb;}
            #depth0 {color: #06bfe5;}
            #depth1 {color: #09a1e5;}
            #depth2 {color: #0283e5;}
            #depth3 {color: #0062e5;}
            #depth4 {color: #002ee5;}   /* We could use Sass here to have variable selectors and variable color values */

            .hoverable {
                position: relative;
            }

            .hoverable >.hoverable__tooltip {
                display: none;
            }

            .hoverable:hover > .hoverable__tooltip {
                display: inline;
                position: absolute;
                /*bottom: 20px;*/
                left: 150px;
                background: white;
				color: black;
                border: 1px solid black;
				border-radius: 5px;
            }
        </style>

    </head>
    <body>

    <br />
    <div id="section">
		<button data-val="koyan" class="btn activist-btn">koyan</button>
		<button data-val="remy" class="btn activist-btn">remy</button>
		<button data-val="bill" class="btn activist-btn">bill</button>
		<button data-val="maria" class="btn activist-btn">maria</button>
		<button data-val="helen" class="btn activist-btn">helen</button>
		<button data-val="jim" class="btn activist-btn">jim</button>

        <form id="form" method="get" action="index.php">
            <input type="hidden" id="activist-name" name="activist-name" value="<?=$_GET['activist-name'] ?? ''?>" />
        </form>
        <div id="headline">
            <?php
            if(isset($_GET['activist-name']) && $_GET['activist-name'])
                echo $_GET['activist-name'] . '\'s network';
            ?>
        </div>
    </div>
    </body>
</html>

<?php
#Debug mode
#ini_set('display_errors', 'off');

#Autolad all classes found
spl_autoload_register(function ($className) {
	require_once '../' . str_replace("\\","/", $className) . '.php';    #$className example: test1\Action
});

$whales = new Action(1, 'Whales');
$toxics = new Action(2, 'Toxics');
$nukes	= new Action(3, 'Nukes');
$climate= new Action(4, 'Climate');
$ozon   = new Action (5, 'Ozon');

$koyan = new Activist('koyan');
$remy  = new Activist('remy');
$bill  = new Activist('bill');
$maria = new Activist('maria');
$helen = new Activist('helen');
$jim   = new Activist('jim');


$koyan->signAction($whales);
$remy->signAction($whales);
$bill->signAction($whales);
$bill->signAction($nukes);
$maria->signAction($nukes);
$maria->signAction($climate);
$helen->signAction($climate);
$helen->signAction($ozon);
$jim->signAction($ozon);

#Usage code
if (isset($_GET['activist-name']))
{
	/** @var Activist $activist */
	$activist = ${$_GET['activist-name']};          #Get the already instantiated activist object by using variable variable names

	try {
		$network = new ActivistNetwork( $activist );
		$network->view();
	} catch ( \Exception $e ) {
		echo '<div id="error">' . $e->getMessage() . '</div>';
	}
	echo '<br /><a href=".">Clear</a>';
}
?>

<script type="application/javascript">
  let form    = document.getElementById("form");
  let input   = document.getElementById("activist-name");
  let buttons = document.querySelectorAll(".activist-btn");

  buttons.forEach(el => el.addEventListener('click', event => {
	input.value = el.getAttribute("data-val");
	form.submit();
  }));
</script>

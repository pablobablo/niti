# niti
A simple PHP class which allow run asynchronous tasks.

How to use:

```PHP
require( 'niti.php' );
$items = [ 'one', 'two', 'three', 'four', 'five' ];
new Niti( $items, [ 'color' => 'red' ], 3, function( $item, $data ){
    echo "Item: " . $item . ' / Data: ' . $data[ 'color' ] .  "\n";
});

```

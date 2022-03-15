# Monday PHP
A helper package for using the Monday.com API in PHP, including Laravel

## BETA Package
Please note this package is currently in Beta.

Full coverage of Monday API is not yet available, but key functionality is ready.

If you have requirments outside of the current scope either raise an issue or send a pull request

## Installation
Install through Composer (currently in Beta, remove dev-master once we move to a stable release)

```composer require "awcode/monday-php" "dev-master"```

Or manually adding

```json
{
    "require": {
        "awcode/monday-php": "dev-master"
    }
}
```

## Usage 

```include('vendor/autoload.php');
// Set MONDAY_TOKEN=your-monday-api-token in Environment Variable or .env file
// Create new Monday Instance
$monday = new \Awcode\MondayPHP\MondayPHP;

// Create new Monday Board
$board = $monday->createBoard('test_board 123');
// Create new Item in default Group
$board->createItem('test_item 444');
// Create new Group
$group = $board->createGroup('test group 123');
// Create new Item in specific Group
$board->createItem('test_item 666', $group->getId());


// Fetch board by ID
$board = $monday->boards($board->getId())->first();
echo($board->getName().'<br>'.$board->getId());
// Get board items
foreach ($board->items() as $item) {
    echo('<br>'.$item->getName());
}

```

### Support and Contributing
This has been built by the team at [AWcode](https://awcode.com), for both our internal needs and to support the PHP developer community.
Please run your own tests to ensure that this fits your needs, no warranty or guarantee is provided.

If you have any questions, feedback or issues please raise an Issue on this repository.

Contributors are welcome to submit pull requests for review.

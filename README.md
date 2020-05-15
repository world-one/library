# php library

- Utils
- ResultToJson
- RssFeed(test)

### composer.json
add 'repositories'
```
{
  "repositories": {
    "library": { 
      "type": "package",
      "package": {
        "name": "world-one", 
        "version": "1.0",
        "source": {
          "url": "https://github.com/world-one/php-library.git", 
          "type": "git",
          "reference": "1.0"
        },
        "autoload": {
          "psr-4": {
              "Wo\\": "src/Wo"
          }
        }
      }
    }
  },
  "require": {
      "world-one":"1.0"
  }
}
```

```
$comopser install
```

### Utils

#### use
```
use Wo\Utils;

$utils = new Utils();
$req = [ 'name'=> 'jeong','phone'=>'01012341234', 'password'=>'12341234'];
$utils->paramsCheck( $req, ['name','phone','password'], -4 );

or

Utils::paramsCheck( $req, ['name','phone','password'], -4 );
```

#### result / error message

```
return true;

or 

{
    "success": false,
    "result": {
        "code": -4,
        "message": "require parameter [password] value empty"
    }
}
```

### ResultToJson
test medium feed
#### use
```
use Wo\ResultToJson;

$return = new ResultToJson();

$return->success($result);
$return->error(-202, '이름이 없습니다.');

or

ResultToJson::success([ 'a', 'b', 'c' ]);
```

#### result / error message
```
{
    "success": true,
    "result": {
        "name": "a",
        "addresss": "b",
        "phone": 12341234
    }
}

{
    "success": false,
    "result": {
        "code": -202,
        "message": "이름이 없습니다."
    }
}
```

###RssFeed

####use
```
use Wo\RssFeed;
$feed = new RssFeed();
$result = $feed->get(https://medium.com/@ngoeke);
```

###result
```
array(3) {
  ["title"]=>
  string(33) "Stories by Niklas Göke on Medium"
  ["link"]=>
  string(57) "https://medium.com/@ngoeke?source=rss-e4d971c7eba7------2"
  ["list"]=>
  array(3) {
    [0]=>
    array(6) {
      ["title"]=>
      string(32) "The 3 Mindsets That Build Wealth"
      ["link"]=>
      string(109) "https://entrepreneurshandbook.co/the-3-mindsets-that-build-wealth-9339150202da?source=rss-e4d971c7eba7------2"
      ["category"]=>
      string(6) "wealth"
      ["date"]=>
      string(10) "2020-05-14"
      ["description"]=>
      string(98) " Stop playing not to lose, and start playing to win Continue reading on Entrepreneur's Handbook »"
      ["image"]=>
      string(59) "https://cdn-images-1.medium.com/max/2600/0*JJXuKmDtwtrB5kX_"
    }
    [1]=>
    array(6) {
      ["title"]=>
      string(42) "How To Break Bad Habits and Form Good Ones"
      ["link"]=>
      string(115) "https://medium.com/mind-cafe/how-to-break-bad-habits-and-form-good-ones-3ae9b484628b?source=rss-e4d971c7eba7------2"
      ["category"]=>
      string(10) "psychology"
      ["date"]=>
      string(10) "2020-05-13"
      ["description"]=>
      string(93) " “Habits are the compound interest of self-improvement.” Continue reading on Mind Cafe »"
      ["image"]=>
      string(59) "https://cdn-images-1.medium.com/max/2600/0*dZ2VArGYi5g2-utD"
    }
    [2]=>
    array(6) {
      ["title"]=>
      string(51) "How Domino’s Turns Your Cupboard Into a Billboard"
      ["link"]=>
      string(128) "https://medium.com/better-marketing/how-dominos-puts-ads-right-on-your-kitchen-table-df668230e159?source=rss-e4d971c7eba7------2"
      ["category"]=>
      string(10) "psychology"
      ["date"]=>
      string(10) "2020-05-13"
      ["description"]=>
      string(40) " Continue reading on Better Marketing »"
      ["image"]=>
      string(70) "https://cdn-images-1.medium.com/max/2600/1*AgWZBwU7tZrROOC8ADkHsA.jpeg"
    }
  }
}
```
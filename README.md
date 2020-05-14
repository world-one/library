#php library

- Utils
- ResultToJson
- RssFeed(test)

###composer.json
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

###Utils

####use
```
use Wo\Utils;

$utils = new Utils();
$req = [ 'name'=> 'jeong','phone'=>'01012341234', 'password'=>'12341234'];
$utils->paramsCheck( $req, ['name','phone','password'], -4 );

or

Utils::paramsCheck( $req, ['name','phone','password'], -4 );
```

####result / error message

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

###ResultToJson

####use
```
use Wo\ResultToJson;

$return = new ResultToJson();

$return->success($result);
$return->error(-202, '이름이 없습니다.');

or

ResultToJson::success([ 'a', 'b', 'c' ]);
```

####result / error message
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
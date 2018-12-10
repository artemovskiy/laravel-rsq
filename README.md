#Laravel Remote Structured Queries
As SQL but JSON and safe(probably)
##Concept
Specify models selection and representation through special `query` field. Query is special json
 structure like: 
 ```
{
    "fileter": {
        "is_confirmed": 1,
        "age": {
            "sign": ">=",
            "value": "18"
        }
    },
    "sort": {
        "age": "asc"
    }
}
``` 
##Setup
1. Add `Xydens\LaravelRSQ\RSQServiceProvider::class` to `providers`
2. Optionally add `"RSQ" => Xydens\LaravelRSQ\Factory::class` to `aliases`
3. Add `Xydens\LaravelRSQ\RemoteQueryable` trait to models, what you want to query
##Usage
###Simple example
In your controller:
```
use App/User; //Model
use Illuminate\Http\Request;
use RSQ;

class UserController extends Controller
{

    public function query(Request $request){
        $query = RSQ::requestOrSession($request,User::class);
        return Review::RSQ($query)->get();
    }
}
```
Now you can add `qurey` field to request.


# Profiling JSON responses in Laravel
    
**Setup**

Set middleware in middle property in `App\Http\Kernel`
```
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        ...
        ...
        \Axterisko\ProfileJsonResponse\Middleware\ProfileJsonResponse::class
    ];
}
```


For limitation profiling data output, create in `config\app.php` the key `profile-json-response-data` ans set property keys
```
...

'profile-json-response-data' = ['queries'],

...

```

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
        \Axterisko\ProfileJsonResponse\Middleware\ProfileJsonResponse::class
    ];
}
```

Set `profile` param in request for getting debug info in json response

For limitation profiling data output, set `$profilingData` property keys
```
protected $profilingData = ['queries'];
```

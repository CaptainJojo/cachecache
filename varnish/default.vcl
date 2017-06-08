vcl 4.0;

import std;

# Default backend definition. Set this to point to your content server.
backend default {
    .host = "nginx";
    .port = "80";
}

sub vcl_recv {
    // Add a Surrogate-Capability header to announce ESI support.
    set req.http.Surrogate-Capability = "abc=ESI/1.0";
}


sub vcl_backend_response {
    # Happens after we have read the response headers from the backend.
    #
    # Here you clean the response headers, removing silly Set-Cookie headers
    # and other mistakes your backend does.

    # Serve stale version only if object is cacheable
    if (beresp.ttl > 0s) {
      #  set beresp.grace = 1h;
    }

    set beresp.grace = 0s;
    # Objects with ttl expired but with keep time left may be used to issue conditional (If-Modified-Since / If-None-Match) requests to the backend to refresh them
    #set beresp.keep = 10s;

    # Custom headers to give backends more flexibility to manage varnish cache
    if (beresp.http.X-Cache-Varnish-Maxage) {
        set beresp.ttl = std.duration(beresp.http.X-Cache-Varnish-Maxage + "s", 3600s);
    }
    if (beresp.http.X-Cache-Varnish-Grace && beresp.ttl > 0s) {
    #    set beresp.grace = std.duration(beresp.http.X-Cache-Varnish-Grace + "s", 3600s);
    }

    # if the object is cacheable, add some usefull headers for the ban lurker
    if (beresp.ttl > 0s) {
        set beresp.http.X-Url  = bereq.url;
        set beresp.http.X-Host = bereq.http.host;
    }

    if (beresp.http.Surrogate-Control ~ "ESI/1.0") {
        unset beresp.http.Surrogate-Control;
        set beresp.do_esi = true;
    }

    # Some more usefull headers for debug
    set beresp.http.X-Real-Ttl   = beresp.ttl;
    set beresp.http.X-Real-Grace = beresp.grace;
    set beresp.http.X-Real-Keep  = beresp.keep;
}

sub vcl_deliver {
    # Happens when we have all the pieces we need, and are about to send the
    # response to the client.
    #
    # You can do accounting or modifying the final object here.

    unset resp.http.X-Powered-By;

    if (obj.hits > 0) {
        set resp.http.X-Cache = "HIT";
    } else {
        set resp.http.X-Cache = "MISS";
    }
}

# Hosting

Accelerate your online projects with hosting self managed, purpose-built platform that handles hosting for different languagues, and environment cloning. Your team can focus on building great online experiences, for the mid-tier market.

## Installation
Currently the application needs a debian host operating system. The client domains uses docker compose to create a separate entity that serves responses through a NGINX proxy. There is a plan to use Kubernetes as an option when product matures.

### Install script.
```
curl -O https://raw.githubusercontent.com/purencool/hosting/refs/heads/main/install.sh && bash ./install.sh debian && cd app && rm ../install.sh && ./cli
```
### Cli tool 
```
echo 'export PATH="$HOME<path to app>:$PATH"' >> ~/.bashrc
chmod +x $HOME/<path to app>/cli
source ~/.bashrc
```

## Searching config
#### Finding specific data using keys structure.
This requires jq to be installed.
```
cli config | jq -c '.. | .<key foo>? | select(. != null)'
```
#### Searching for element in the configuration and provides the path.
```
cli config:find <foo> 
```
Example 
```
cli config:find example.com

// Result
{
    "results": "domain:mydomain.com, environment:production, path:9 -> system -> user -> domains -> 1 -> example.com",
    "results_raw": [
        9,
        "system",
        "user",
        "domains",
        1
    ]
},
```

## Updating config
The command below will only update the user configuration object 
and has no access to the system object for the same site.
```
cli config:update <default.domain> <environment> <json string>
```
Examples
```
cli config:update mydomain.com production '{"domains":"example.com"}'
cli config:update mydomain.com production '{"code_management":{"actions":"composer up"}}'
```

## Removing config
The command below will only update the user configuration object 
and has no access to the system object for the same site.
```
cli config:remove <default.domain> <environment> <json string>
```
Example
```
cli config:remove mydomain.com production '{"domains":"example.com"}'
```

#### Find data structure 
Find anything in user configuration across the platform.
```
cli config:find  example.com.a1
```

## App development
#### End point test example
```
curl  http://localhost:8000/api -H "Content-Type: application/json" -d '{"response_format":"raw","request_type":"domains_list"}'
```

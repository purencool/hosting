# Hosting

Accelerate your online projects with hosting self managed, purpose-built platform that handles hosting, your team can focus on building great online experiences. Environment cloning, for the mid-tier market.

## Installation
Currently it needs a debian based and the hosting and uses docker compose in each environment. There is a plan to use Kubernetes as the product matures.

### Install script.
```
curl -O https://raw.githubusercontent.com/purencool/hosting/refs/heads/main/install.sh && bash ./install.sh debian && cd app && rm ../install.sh && ./cli
```
### Cli 
```
echo 'export PATH="$HOME<path to app>:$PATH"' >> ~/.bashrc
chmod +x $HOME/<path to app>/cli
source ~/.bashrc
```

## Searching config
This requires jq to be installed.
#### Finding specific data using keys structure.
```
cli config | jq -c '.. | .<key foo>? | select(. != null)'
```
#### Searching for key and provide the data path.
```

```
#### Find data structure 

## App development
#### End point test example
```
curl  http://localhost:8000/api -H "Content-Type: application/json" -d '{"response_format":"raw","request_type":"domains_list"}'
```

# Hosting

Accelerate your online projects with hosting self managed, purpose-built platform that handles hosting, your team can focus on building great online experiences. Environment cloning, for the mid-tier market.


## Installation
Currently it needs a debian based host and uses docker compose in each environment.

```
curl -O https://raw.githubusercontent.com/purencool/hosting/refs/heads/main/install.sh && bash ./install.sh debian && cd app && rm ../install.sh && ./cli
```


## App development

#### End point tests
```
curl  http://localhost:8000/api -H "Content-Type: application/json" -d '{"response_format":"raw","request_type":"domains_list"}'
```

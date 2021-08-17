# VSCode Instant markdown vuln demo 
This repo is to demonstrate the file traversal vulnerability which uses a exploit in the Instant Markdown VSCode extension 

## Requisites 
- Ngrok installed 
- PHP installed
- VSCode with Instant Markdown 1.4.6 extension installed 

## Getting Started 
Theres 2 main elements to setting this up, The attacker which will use ngrok to serve a locally running website using Ngrok while the target will use VSCode with an extension that has our known exploit. The goal here is to demonstrate how an attacker can use VSCode to do a file traversal to remotely gain a file from the target. 

### The attacker
- PHP > run the webserver in the root folder containing the scripts above, start the webserver in a terminal session using `php -S localhost:8123`
- Ngrok > start ngrok pointing to the same port as php, change yourdomain with a custom name and start Ngrok using `ngrok http 8123 -subdomain=yourdomain` 

Once you have your custom subdomain edit index.php and update line 60 using your custom Ngrok subdomain

### The target 
When i run the target i use a VM with OSX running and install the latest VSCode, although you can just as easily run this in your local env (just be aware of security beyond the demo!).

You'll also need to install the Instant Markdown extension from the VSCode extension marketplace, once installed click the dropdown next to uninstall and select "install another version" and choose 1.4.6. 

Create a markdown doc (or open this one) and let it open in a browser, this will start the local webserver so you can see live updates from the markdown.

In the home directory, via terminal, create a file called passwords and enter some text in there (anything you want). 

### Executing the attack 
Open the link in the browser on the target machine 

## Further reading 

https://snyk.io/blog/vulnerable-visual-studio-code-extensions-marketplace/

https://snyk.io/blog/visual-studio-code-extension-security-vulnerabilities-deep-dive/

https://github.com/Kirill89/visual-studio-code-extension-security-vulnerabilities

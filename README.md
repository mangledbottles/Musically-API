# TikTok Private API (Musically API)
![TikTok Logo](https://i.imgur.com/JArtreY.png "TikTok Private API")
Reverse engineered TikTok (previously Musically) Private API written in PHP, this project is no longer maintained.

## Background
This API was reverse engineered using [MITM (Man in the middle) Attacks](https://en.wikipedia.org/wiki/Man-in-the-middle_attack) to intercept encrypted API requests between the TikTok iOS Application and the TikTok API Server.

The tools used to capture the endpoints were [Charles Proxy](https://charlesproxy.com), [SSL Proxying](https://www.charlesproxy.com/documentation/proxying/ssl-proxying/), and [SSL Kill Switch](https://github.com/nabla-c0d3/ssl-kill-switch2) for [SSL Certificate Pinning](https://www.digicert.com/dc/blog/certificate-pinning-what-is-certificate-pinning/).

### Charles Proxy
> Charles is an HTTP proxy / HTTP monitor / Reverse Proxy that enables a developer to view all of the HTTP and SSL / HTTPS traffic between their machine and the Internet enables a developer to view all of the HTTP and SSL / HTTPS traffic between their machine and the Internet.
Charles allows you to set up a local VPN connection that monitors any devices traffic including sockets.

### SSL Proxying
[Transport Layer Security (TLS)](https://en.wikipedia.org/wiki/Transport_Layer_Security) which has replaced [Secure Socket Layer (SSL)](https://en.wikipedia.org/wiki/Transport_Layer_Security) creates an E2EE (end-to-end encrypted) connection between a client and a server (eg your phone and a website).
TikTok's API used TLS encryption, so any data send between the TikTok App and the TikTok servers through Charles Proxy is completely encrypted and cannot be read.
However, SSL Proxying can be used to surcumvent this protection.

By installing a custom SSL Certificate on your device, you hold the decryption keys to the encrypted data and can view all requests in plain text.

### SSL Certificate Pinning
The strongest protection developers take to secure their APIs from being intercepted is SSL Certificate Pinning.
[This article](https://www.digicert.com/dc/blog/certificate-pinning-what-is-certificate-pinning/ "Certificate Pinning Article") explains Certificate Pinning in greater detail however it is a checker built into the application. It ensures that the SSL/TLS Certificate is one approved by a certificate authority (CA). This causes all requests where Charles Proxy is attempting to intercept requests using SSL Proxying as the device trusted SSL/TLS Certificate is invalid.

This can be circumvented on a [Jailbroken iOS Device](https://en.wikipedia.org/wiki/IOS_jailbreaking) by installing [SSL Kill Switch](https://github.com/nabla-c0d3/ssl-kill-switch2). This software provides the ability to patch low-level functions responsible for handling SSL/TLS connections in order to override and disable the system's default certificate validation, as well as any kind of custom certificate validation (such as certificate pinning).

### TikToks Progressive Steps to Prevent API Monitoring
Security through ambiguity does not work. However, TikTok now send a unique ID header with every single request that comprised of many factors. This header is verified by the server and if the unique ID is incorrect, the request is rejected. The unique ID is assumed to contain details such as Timestamp, Device ID and API endpoints. This unique ID algorithm can be reverse engineered. The difficulty is reverse engineering the whole iOS application. There have been many projects that have succesfully reverse engineered these unique IDs. 

## How to use
See examples in /examples
Most API endpoints are depreciated at this point, proof of concept testing may occur.

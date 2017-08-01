### Prerequisites

Docker


### Steps for running the application

 * Pull the image using 
     - ``` docker pull ashatp/tradetracker:1.0 ```
 * Start the container using below command
   - ``` docker run --rm -d --name demo -p 8000:80 ashatp/tradetracker:1.0```
* Install dependencies using
   - ``` docker exec -it demo /bin/bash bin/run.sh ```

* To run the application, go to ``` http://localhost:8000/product``` in browser.
* URL for feed : http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2&additionalType=2&limit=100


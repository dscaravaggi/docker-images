# linux-php8-rdbms

suppose you builkd a tag prova1 

### build tag
docker build -f Dockerfile -t prova1 .

### test 
docker run --name prova1 -p 8079:80 --detach prova1

### clean 
docker stop prova1 ; docker rm prova1 ; docker rmi prova1 ;

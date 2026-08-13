Desafío 1
En este desafio para que se cumpla la condición habia un problema a corregir la condicion de vencimiento siempre era verdadera, evaluaba el string de fecha como booleano antes de comparar, por lo que cualquier fecha no vacía ya devolvia true y el continue se disparaba siempre. Lo corregi cubriendo también los casos con vencimiento nulo.
Tambien habia una propiedad inexistente en la comparación de tipos, Se comparaba $lote->client_ID contra un int, cuando en getLotes() el valor se casteaba un string. Entonces la comparación estricta entre tipos distintos nunca daba una  igualdad. Entonces la corregi a $lote->clientID !== (string) $clientID
Campo de monto era inexistente. Se sumaba $lote->monto, propiedad que no exise entonces la corrigi a $lote->precio
Lógica de status/message estaba invertida. El código arrancaba asumiendo status: true y lo cambiaba a false al encontrar un lote, que era lo opuesto de lo esperado. Lo inverti: por defecto status false / "No hay Lotes para cobrar", y al encontrar coincidencias pasa a status true "Tienes Lotes para cobrar"

Desafío 2

En este desafio el primer problema que encontre fue el LIMIT 2 en el query que impedía traer más de 2 registros aunque el lote tuviera más coincidencias por lo que la ajuste
El tipado estaba incorrecto en el parámetro, la función recibía int $loteID pero el identificador de lote era un código con ceros a la izquierda ("00148"). Al estar como int PHP convertía el string y perdía los ceros a la izquierda haciendo la que comparación siempre este mal . Ajuste el tipo a string tanto en retriveLotes como en getLotes

Desafío 3

El servicio se implementó como un endpoint HTTP servido con el servidor de PHP, recibiendo el id como query string: GET /lote.php?id={id}
Casos contemplados y status HTTP
id inválido o ausente	400 Bad Request	{ "status": false, "message": "Debe indicar un id de lote válido" }
id no existe en la base	404 Not Found	{ "status": false, "message": "Lote no encontrado" }
id encontrado	200 OK	{ "status": true, "message": "Lote encontrado", "data": { ... } }
Para ejecutarlo php -S localhost:8000
probar los distintos casos: 
curl "http://localhost:8000/lote.php?id=6"
curl "http://localhost:8000/lote.php?id=999"
curl "http://localhost:8000/lote.php?id=abc"

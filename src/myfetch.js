const url = 'http://localhost/Fetch_mysql_angular/requests.php';

const myfetch = (action, objData) => {
  objData ? objData : null;
  let data = new FormData();
    data.append( "action", action);
    data.append( "data", JSON.stringify( objData ));

  return fetch(url, {
      method: "POST",
      body: data,
      headers: new Headers(),
    })
    .then( response => {
        console.log(response)
        try {
            return response.json()
        }catch(err){
            console.log(err)
        }
    })
    // .then( response => JSON.parse(response) )
    
}; 


export default myfetch;
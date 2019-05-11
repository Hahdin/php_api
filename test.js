'use strict'
/**
 * Handle the click 
 * fetch from the api, reading the records of the account number
 */
const handleGetRecord = async  () =>{
  let el = document.getElementById('account');
  let dv = document.getElementById('res');

  dv.innerHTML = 'Please wait...';
  try
  {
    let js = await fetchFromAPI(`http://localhost:9000/api/read/${el.value}`)
    dv.innerHTML = js.map(item => `${JSON.stringify(item)}<br/>`);
  }
  catch(e)
  {
    dv.innerHTML = e;
  }
}
/**
 * Get all the records
 */
const handleGetAllRecords = async  () =>{
  let dv = document.getElementById('res');
  dv.innerHTML = 'Please wait...';
  try
  {
    let js = await fetchFromAPI(`http://localhost:9000/api/search`)
    dv.innerHTML = js.map(item => `${JSON.stringify(item)}<br/>`);
  }
  catch(e)
  {
    dv.innerHTML = e;
  }
}

/**
 * Call the API
 * @param {string} path API endpoint
 */
const fetchFromAPI = async (path) =>{
  try
  {
    let res = await window.fetch(path);
    return await res.json();
  }
  catch(e)
  {
    throw Error(e);
    return null;
  }
}



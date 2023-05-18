/* Custom fetch function that returns a promise */

function myFetch(url, type, data) {

    /* GET */
    if (type === "GET") {
    return fetch(url, {
    method: type,
    headers: {
        'Content-type': 'application/json'
    }
    })
    .then(res => {
        if (res.ok) { console.log("HTTP request successful") }
        else { console.log("HTTP request unsuccessful") }
        return res
    })
    .then(res => res.json())
    .then(data => data)
    .catch(error => error)
    }
 
    /* DELETE */
    if (type === "DELETE") {
    return fetch(url, {
    method: type,
    headers: {
        'Content-type': 'application/json'
    }
    })
    .then(res => {
        if (res.ok) { console.log("HTTP request successful") }
        else { console.log("HTTP request unsuccessful") }
        return res
    })
    .catch(error => error)
    }
 
    /* POST or PUT */
    if (type === "POST" | type === "PUT") {
    return fetch(url, {
    method: type,
    headers: {
        'Content-type': 'application/json'
    },
    body: JSON.stringify(data)
    })
    .then(res => {
        if (res.ok) { console.log("HTTP request successful") }
        else { console.log("HTTP request unsuccessful") }
        return res
    })
    .then(res => res.json())
    .then(data => data)
    .catch(error => error)
    }
}
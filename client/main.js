import "normalize.css"
import {post} from "./api/Request.js";
import Sortable from 'sortable';

const lists=document.getElementById("lists")


const data= {
    "dt":"abc"
}

// const data=new FormData()
// data.append("dt","abc")
post(JSON.stringify(data), "index.php").then(response=>response)
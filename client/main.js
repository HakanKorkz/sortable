import "normalize.css"
import categories from "./module/Categories.js";
import {get, post} from "./api/Request.js";

categories()

//sortable()


const data= {
    "dt":"abc"
}

post("App/Index", JSON.stringify(data)).then(response => response)
get("api/index").then(response => response)
import "normalize.css"
import categories from "./module/Categories.js";
import {get, post, postJson} from "./api/Request.js";

categories()

//sortable()





const dataForm=new FormData();
dataForm.append("user",8)
post("", dataForm).then(response => response)

const dataJson= {
    "dt":"abc"
}
postJson("", dataJson).then(response => response)
// get("").then(response => response)
get("profile").then(response => response)
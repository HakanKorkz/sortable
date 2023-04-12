import {post} from "../api/Request.js";


const categories = () => {
    categoryRequest()
}

const categoryRequest = () => {
  const button=document.querySelector("button[type='button']");

  button.addEventListener("click",async ()=>{
      const input=document.querySelector("input[name='category_name']")
      const data=JSON.stringify({
          "categoryName":input.value
      })

      try {
          const result=await post("categoryCreate",data)
          console.log(await result)
          return await result
      } catch (e) {
          return e
      }
  })
}


export default categories


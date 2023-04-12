const request = async (href,data, method) => {
    try {
        const options = {
            method,
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: data || null
        }
        console.log(options)
        const response = await fetch(`http://localhost/sortable/server/${href}`, options)
        return response.json()
    } catch (e) {
        return e
    }
}

export const post = async (href,data=null) => await request(`${href}.php`,data, "POST")

export const get=async (href) => await request(href,null,"GET")
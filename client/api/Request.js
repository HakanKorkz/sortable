const request = async (data, href, method) => {
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

export const post = async (data, hef) => await request(data, hef, "POST")
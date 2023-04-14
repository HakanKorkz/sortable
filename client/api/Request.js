const request = async (href, data, method,headers) => {
    try {
        const options = {
            method,
            headers,
        }
        if (data !== null) {
            options.body = data
        }
        console.log(options)
        const response = await fetch(`http://localhost/sortable/server/${href}`, options)
        return response.json()
    } catch (e) {
        return e
    }
}

export const post = async (href, data) => await request(href, data, "POST",{
    "Accept": 'application/json, text/plain, */*',
})
export const postJson = async (href, data) => await request(href, JSON.stringify(data), "POST",{
    "Content-Type": "application/json",
    "Accept": 'application/json, text/plain, */*',
})

export const get = async (href) => await request(href, null, "GET",{
    "Content-Type": "application/json",
    "Accept": 'application/json, text/plain, */*',
})


export const customFetch = async (href,data,method,headers) => await request(href, data, method,headers)
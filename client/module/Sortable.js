import Sortable from "sortablejs";
import {post} from "../api/Request.js";

const lists = document.getElementById("lists")

const sortable = ()=> Sortable.create(lists, {
    handle: '.icon-solid',
    sort: true,
    group: "local-sorts",
    store: {
        /**
         * Get the order of elements. Called once during initialization.
         * @param   {Sortable}  sortable
         * @returns {Array}
         */
        get: function (sortable) {
            post("sorts.php").then(res=>{
                if (res.length !== localStorage.getItem(sortable.options.group.name).split("|").length) {
                    localStorage.setItem(sortable.options.group.name, res.join('|'));
                }
            })

            let order = localStorage.getItem(sortable.options.group.name);

            // return order ? order.split('|')  : list;
            return order.split('|')
        },

        /**
         * Save the order of elements. Called onEnd (when the item is dropped).
         * @param {Sortable}  sortable
         */
        set: function (sortable) {
            let order = sortable.toArray();
            localStorage.setItem(sortable.options.group.name, order.join('|'));
        }
    },
    onChange: function (/**Event*/evt) {
        console.log(evt)
        // console.log(evt.newIndex) // most likely why this event is used is to get the dragging element's current index
        // same properties as onEnd
    }
});

export default sortable
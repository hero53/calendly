import axios from "axios";


async function getData() {
axios
.get("/get_date")
.then((response) => {
this.data = response.data;
})
.catch((error) => {
console.error(error);
});
}

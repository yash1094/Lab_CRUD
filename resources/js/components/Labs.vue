<template>
    <div>
        <h2>Labs</h2>
        <form @submit.prevent="addLab" mb-3>
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    v-model="lab.name"
                    required
                />
            </div>
            <div class="form-group">
                <label for="name">Address</label>
                <gmap-autocomplete
                    @place_changed="setPlace"
                ></gmap-autocomplete>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li
                    class="page-item"
                    v-bind:class="[{ disabled: !pagination.prev_page }]"
                >
                    <a
                        class="page-link"
                        href="#"
                        @click="fetchLabs(pagination.prev_page)"
                        >Previous</a
                    >
                </li>
                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">
                        Page {{ pagination.curr_page }} of
                        {{ pagination.last_page }}
                    </a>
                </li>
                <li
                    class="page-item"
                    v-bind:class="[{ disabled: !pagination.next_page }]"
                >
                    <a
                        class="page-link"
                        href="#"
                        @click="fetchLabs(pagination.next_page)"
                        >Next</a
                    >
                </li>
            </ul>
        </nav>
        <div
            class="card card-body mb-2"
            v-for="lab in labs"
            v-bind:key="lab.id"
        >
            <h3>{{ lab.name }}</h3>
            <h5>{{ "address: " + lab.addr }}</h5>
            <h5>{{ lab.created_at }}</h5>
            <hr />
            <div class="btn-group" role="group" aria-label="Basic example">
                <button @click="editLab(lab)" class="btn btn-warning">
                    Edit
                </button>
                <button @click="deleteLab(lab.id)" class="btn btn-danger">
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            labs: [],
            currentPlace: null,
            lab: {
                id: "",
                name: "",
                addr: "",
                created_at: ""
            },
            lat: "",
            long: "",
            lab_id: "",
            pagination: {},
            edit: false
        };
    },
    created() {
        this.fetchLabs();
    },
    mounted() {
        let ckeditor = document.createElement("script");
        ckeditor.setAttribute(
            "src",
            `https://maps.googleapis.com/maps/api/js?key=${process.env.MIX_MAPS_KEY}&callback=initMap`
        );
        document.head.appendChild(ckeditor);
    },
    methods: {
        // receives a place object via the autocomplete component
        setPlace(place) {
            this.currentPlace = place;
        },
        fetchLabs(page_url) {
            let vm = this;
            page_url = page_url || "/api/labs";
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    var data = res.data;
                    var geocoder = new google.maps.Geocoder();
                    data.forEach(lab => {
                        var latlng = {
                            lat: parseFloat(lab.lat),
                            lng: parseFloat(lab.long)
                        };
                        geocoder.geocode({ location: latlng }, function(
                            results,
                            status
                        ) {
                            if (status === "OK") {
                                lab.addr = results[0].formatted_address;
                            } else {
                                window.alert(
                                    "Geocoder failed due to: " + status
                                );
                            }
                        });
                    });
                    vm.makePagination(res.meta, res.links);
                    this.labs = data;
                    console.log(this.labs);
                    this.$forceUpdate();
                })
                .catch(err => console.log(err));
        },
        makePagination(meta, links) {
            let pagination = {
                curr_page: meta.current_page,
                last_page: meta.last_page,
                next_page: links.next,
                prev_page: links.prev
            };
            this.pagination = pagination;
        },
        deleteLab(id) {
            if (confirm("Are you sure?")) {
                fetch(`api/lab/${id}`, {
                    method: "delete"
                })
                    .then(res => res.json)
                    .then(data => {
                        console.log(data.id);
                        this.fetchLabs();
                    })
                    .catch(err => console.log(err));
            }
        },
        addLab() {
            if (this.currentPlace != null) {
                if (this.edit === false) {
                    //add
                    this.lat = this.currentPlace.geometry.location.lat();
                    this.long = this.currentPlace.geometry.location.lng();
                    this.lab.addr = this.currentPlace.formatted_address;
                    console.log(JSON.stringify(this.lab));

                    delete this.lab.addr;
                    this.lab.lat = this.lat;
                    this.lab.long = this.long;

                    console.log(JSON.stringify(this.lab));

                    fetch("api/lab", {
                        method: "post",
                        body: JSON.stringify(this.lab),
                        headers: {
                            "content-type": "application/json"
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.lab.name = "";
                            this.currentPlace = "";
                            this.fetchLabs();
                        })
                        .catch(err => console.log(err));
                } else {
                    //edit
                }
            } else {
                alert("must provide a valid address");
            }
        },
        editLab(lab) {
            this.edit = true;
            this.lab.id = lab.id;
            this.lab.lab_id = lab.id;
            this.lab.name = lab.name;
            this.lab.lat = lab.lat;
            this.lab.long = lab.long;
        }
    }
};
</script>

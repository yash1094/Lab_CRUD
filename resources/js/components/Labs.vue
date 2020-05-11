<template>
  <div>
    <h2>Labs</h2>
    <form @submit.prevent="addLab" mb-3>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" v-model="lab.name" required />
      </div>
      <div class="form-group">
        <label for="name">address</label>
        <gmap-autocomplete @place_changed="setPlace"></gmap-autocomplete>
        <input type="text" class="form-control" id="name" v-model="lab.address" required />
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page}]">
          <a class="page-link" href="#" @click="fetchLabs(pagination.prev_page)">Previous</a>
        </li>
        <li class="page-item disabled">
          <a
            class="page-link text-dark"
            href="#"
          >Page {{pagination.curr_page}} of {{pagination.last_page}}</a>
        </li>
        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page}]">
          <a class="page-link" href="#" @click="fetchLabs(pagination.next_page)">Next</a>
        </li>
      </ul>
    </nav>
    <div class="card card-body mb-2" v-for="lab in labs" v-bind:key="lab.id">
      <h3>{{ lab.name }}</h3>
      <h5>{{ lab.address }}</h5>
      <h5>{{ lab.created_at }}</h5>
      <hr />
      <button @click="editLab(lab)" class="btn btn-warning">Edit</button>
      <button @click="deleteLab(lab.id)" class="btn btn-danger">Delete</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      labs: [],
      lab: {
        id: "",
        name: "",
        address: "",
        created_at: ""
      },
      lab_id: "",
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchLabs();
  },
  methods: {
    fetchLabs(page_url) {
      let vm = this;
      page_url = page_url || "/api/labs";
      fetch("/api/labs")
        .then(res => res.json())
        .then(res => {
          res.data.forEach(data => {
            // var geocoder = google.maps.Geocoder();
            // console.log(geocoder);
            // var infowindow = new google.maps.InfoWindow();
            // var latlng = { lat: data.lat, lng: data.long };
            // console.log(navigator.geolocation.getCurrentPosition());
          });
          this.labs = res.data;
          console.log(page_url);
          vm.makePagination(res.meta, res.links);
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
            // alert("Lab " + data.name + "has been deleted");
            this.fetchLabs();
          })
          .catch(err => console.log(err));
      }
    },
    addLab() {
      if (this.edit === false) {
        //add
        this.lab.location = Object.values(this.input).reduce(
          (acc, curr) => acc + " " + curr
        );
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
            Object.keys(this.input).forEach(el => (this.input[el] = ""));
            this.fetchLabs();
          })
          .catch(err => console.log(err));
      } else {
        //edit
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
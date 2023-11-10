<template>
    <div>
        <div>
            <label for="selectedCarrier">Choose your carrier:</label>
            <select v-model="selectedCarrier">
                <option value="">Select a carrier</option>
                <option v-for="(carrier) in carriers" :value="carrier.id">{{ carrier.title }}</option>
            </select>
        </div>
        <div>
            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" v-model="weight" />
        </div>
        <button @click="calculate">Calculate</button>
    </div>

           <!-- Field for outputting the result -->
           <div v-if="result !== null">
            <p>Price: {{ result }}</p>
        </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Price",
        props: {
            carriers: Object,
        },
        created() {
            console.log(this.carriers);
        },
        data() {
            return {
                selectedCarrier: "",
                weight: "",
            };
        },
        methods: {
            async calculate() {
                if (!this.selectedCarrier || !this.weight) {
                    alert("Please select a carrier and enter the weight.");
                    return;
                }

                try {
                    // Sending data to the Symfony server
                    const response = await axios.post('/calculate', {
                        carrierId: this.selectedCarrier,
                        weight: this.weight
                    });
                    // Processing the response from the server (if needed)
                    console.log("Response from Symfony:", response.data);
                    this.result = response.data.price;
                } catch (error) {
                    console.error("Error sending data to Symfony:", error);
                }
            },
        },
    };
</script>


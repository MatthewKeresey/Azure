const express = require('express');
const cors = require('cors');
const axios = require('axios');

const app = express();
app.use(cors());

const API_KEY = '4e7bc8140f709452bda0d5ee8f3e71f96c1deb0fcdb13403c9c1b123321dff2f8ceccab48e00684f';

app.get('/api/reports', async (req, res) => {
    try {
        const response = await axios.get('https://api.abuseipdb.com/api/v2/reports', {
            params: {
                page: 1,
                perPage: 100
            },
            headers: {
                'Key': API_KEY,
                'Accept': 'application/json'
            }
        });
        res.json(response.data);
    } catch (error) {
        console.error('Error fetching data:', error);
        res.status(500).json({ error: 'An error occurred while fetching data' });
    }
});

const PORT = 3000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
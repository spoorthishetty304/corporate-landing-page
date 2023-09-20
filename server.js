const express = require('express');
const bodyParser = require('body-parser');
const mongoose = require('mongoose');

const app = express();
const PORT = process.env.PORT || 3000;

// Connect to MongoDB (adjust the connection string as needed)
mongoose.connect('mongodb://localhost:27017/config', {
    useNewUrlParser: true,
    useUnifiedTopology: true,
});

app.get('/', (req, res) => {
    // Handle the root URL request here
});

// Define a user schema and model (modify as needed)
const userSchema = new mongoose.Schema({
    username: String,
    email: String,
});

const User = mongoose.model('User', userSchema);

app.use(bodyParser.urlencoded({ extended: true }));

// Serve static files (HTML, CSS, etc.)
app.use(express.static('public'));

// Define a route to serve the registration form
app.get('/register', (req, res) => {
    res.sendFile(__dirname + '/public/register.html');
});

// Handle registration form submission
app.post('/register', (req, res) => {
    const { username, email } = req.body;

    // Create a new user document and save it to the database
    const newUser = new User({ username, email });
    newUser.save((err) => {
        if (err) {
            console.error(err);
            res.send('Registration failed.');
        } else {
            res.send('Registration successful!');
        }
    });
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});

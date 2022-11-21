const express = require('express')
const { products } = require("./productsUtils")
const ChipdealsApi = require("@chipdeals/momo-api")

//set your apikey here
ChipdealsApi.setApiKey("test_FOdigzgSopV8GZggZa89")

const app = express()
app.set('view engine', 'ejs');
app.use(express.json())
const port = 3000

let transactionResponse = {
    error: false,
    success: false,
    pending: true,
}


app.get('/', (req, res) => {
    res.render("index", {
        products
    })
})

app.post('/requestpayment', (req, res) => {
    const body = req.body
    console.log(body)

    ChipdealsApi
        .collect()
        .amount(body.amount)
        .from(body.phoneNumber)
        .amount(body.amount)
        .currency("XOF")
        .firstName(body.firstName)
        .lastName(body.lastName)
        .create(() => {
            console.log("ok")
            res.send(transactionResponse)
        }).onStatusChanged((transaction) => {
            transactionResponse = {
                error: false,
                success: false,
                pending: true,
                transaction: transaction
            }
        }).onSuccess((transaction) => {
            transactionResponse = {
                error: false,
                success: true,
                pending: false,
                transaction: transaction
            }
        }).onError((transaction) => {
            transactionResponse = {
                error: true,
                success: false,
                pending: false,
                transaction: transaction
            }

            try {
                res.send(transactionResponse)
            } catch (error) {
                console.error(error.message)
            }
        })
})

app.get('/status', (req, res) => {
    res.send(transactionResponse)

})

app.use('/static', express.static('public'));

app.listen(port, () => {
    console.log(`Demo listening on port ${port}`)
})
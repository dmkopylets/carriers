# zoo carriers price calculator
(Symfony RestAPI) obtaining shipping costs for each of the specified carriers, according to their formulas


**to build the test task program, use commands:**

make dc-build

make bash

composer update

exit 

**to start the test task program, use:**

make dc-up

**it will be possible to test the application in a browser at**
    http://localhost/price - VUE fronted
    ![143226.png](Addons%2F143226.png)

Implemented: inheritance, abstract classes, a service class for calculating costs, which will receive a transport service class and input data from the client (in this case, the weight of the parcel)

and also: Docker containerization system

and also: rendering Vue.js input fields (without fanaticism, everything is simple)

**it will be possible to test API respon of carriers list at**
    http://localhost/carriers 
    ![api_carriers_list.png](Addons%2Fapi_carriers_list.png)

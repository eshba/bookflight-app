import axios from "axios";
import { GET_FLIGHTS, FLIGHT_ERROR } from "./types";


//Get Flights
export const getFlights = ({ to, day, isreturn }) => async (dispatch) => {
    
    try {
        const res = await axios.get(`api/flights/list?to=${to}&isreturn=${isreturn==2 ? 1 : 0}&day=${day}`);

        dispatch({
            type: GET_FLIGHTS,
            payload: res.data
        })
    } catch(err) {
        dispatch({
            type: FLIGHT_ERROR,
            payload: ""
        })
    }
}
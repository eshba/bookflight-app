import { GET_FLIGHTS, FLIGHT_ERROR } from "../actions/types";

const initialState = {
    flights:[],
    flight:null,
    error: {}
};

export default function(state = initialState, action) {

    const { type, payload } = action;

    switch(type) {
        case GET_FLIGHTS:
            return {
                ...state, 
                flights:payload
            };
        case FLIGHT_ERROR:
            return {
                ...state, 
                error: "ERROR OCCURRED!"
            };
        default:
            return state;
    }
}
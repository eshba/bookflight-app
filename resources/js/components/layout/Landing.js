import React, { useState } from "react";
import { connect } from "react-redux";
import propTypes from 'prop-types';
import { getFlights } from "../../actions/flight";

const Landing = ({ getFlights, flight: { flights } }) => {
    const [formData, setFormData] = useState({
        'to': '',
        'day': '',
        'isreturn': "1"
    });

    const { to, day, isreturn } = formData;

    const onChange = (e) => setFormData({...formData, [e.target.name] : e.target.value}); 

    const onSubmit = async (e) => {
        e.preventDefault();

        console.log(formData);
        
        getFlights(formData);
    }

    return (
        <section className="landing">
        <div className="dark-overlay">
            <div className="landing-inner">
                <h1 className="x-large">Book Your Flight</h1>
                <p className="lead">
                    Book flights to places.
                </p>
                <form className="form" onSubmit={onSubmit}>
                    <div className="form-group">
                        <div className="radio">
                            <input 
                                type="radio" 
                                name="isreturn" 
                                value="1"
                                id="one"
                                checked={isreturn === "1"}
                                onChange={onChange}
                            /> 
                            ONEWAY
                        </div>
                        <div className="radio">
                            <input 
                                type="radio" 
                                name="isreturn" 
                                value="2"
                                id="round"
                                checked={isreturn === "2"}
                                onChange={onChange}
                            /> 
                            ROUND TRIP
                        </div>
                    </div>
                    <div className="rowwrap-form">
                    <div className="form-group">
                        <input 
                            type="text"
                            placeholder="From"
                            name="from"
                            value="Mumbai"
                            readOnly
                        />
                    </div>
                    <div className="form-group">
                        <input 
                            type="text"
                            placeholder="To"
                            name="to"
                            value={to}
                            onChange={onChange}
                            required
                        />
                    </div>
                    <div className="form-group">
                        <select name="day" value={day} onChange={onChange}>
                            <option value="">Select a WeekDay</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                        </select>
                    </div>
                    <input type="submit" className="btn btn-primary" value="Show Flights" />
                    </div>
                </form>
                <div>
                { flights.Success && 
                    flights.Data.map((flight,index) => (
                        <p className="lead">
                            flights.
                        </p>
                    ))
                }
                </div>
            </div>
        </div>
        </section>
    );
}

Landing.propTypes = {
    getFlights: propTypes.func.isRequired,
    flight: propTypes.object.isRequired
};

const mapStateToProps = (state) => ({
    flight: state.flight
});

export default connect(mapStateToProps, { getFlights })(Landing);
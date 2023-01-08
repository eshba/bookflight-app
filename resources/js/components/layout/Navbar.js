import React, { Fragment } from "react";
import { Link } from 'react-router-dom';

const Navbar = () => {

    const guestLinks = (
        <ul>
          <li>
            <Link to="/">Flights</Link>
          </li>
          <li>
            <Link to="/register">Register</Link>
          </li>
          <li>
            <Link to="/login">Login</Link>
          </li>
        </ul>
    );

    return (
        <nav className="navbar bg-dark">
        <h1>
            <Link to="/">
            <i className="fas fa-plane" /> Book Your Flight
            </Link>
        </h1>
        <Fragment>{guestLinks}</Fragment>
        </nav>
    );
}

export default Navbar;
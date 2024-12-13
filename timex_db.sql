--
-- PostgreSQL database dump
--

-- Dumped from database version 15.2
-- Dumped by pg_dump version 15.2

-- Started on 2023-07-24 14:09:25

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2 (class 3079 OID 41135)
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- TOC entry 4632 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis IS 'PostGIS geometry and geography spatial types and functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 277 (class 1259 OID 57369)
-- Name: blacklists; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.blacklists (
    id bigint NOT NULL,
    user_id integer,
    user_device_id character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.blacklists OWNER TO postgres;

--
-- TOC entry 276 (class 1259 OID 57368)
-- Name: blacklists_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.blacklists_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.blacklists_id_seq OWNER TO postgres;

--
-- TOC entry 4633 (class 0 OID 0)
-- Dependencies: 276
-- Name: blacklists_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.blacklists_id_seq OWNED BY public.blacklists.id;


--
-- TOC entry 281 (class 1259 OID 57439)
-- Name: booking_additional_charges; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_additional_charges (
    id bigint NOT NULL,
    booking_id integer NOT NULL,
    charges_name character varying(255) NOT NULL,
    charges_amount double precision DEFAULT '0'::double precision NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.booking_additional_charges OWNER TO postgres;

--
-- TOC entry 280 (class 1259 OID 57438)
-- Name: booking_additional_charges_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_additional_charges_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_additional_charges_id_seq OWNER TO postgres;

--
-- TOC entry 4634 (class 0 OID 0)
-- Dependencies: 280
-- Name: booking_additional_charges_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_additional_charges_id_seq OWNED BY public.booking_additional_charges.id;


--
-- TOC entry 258 (class 1259 OID 42241)
-- Name: booking_qoutes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_qoutes (
    id bigint NOT NULL,
    booking_id bigint NOT NULL,
    driver_id bigint NOT NULL,
    price double precision NOT NULL,
    hours integer NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    comission_amount double precision DEFAULT '0'::double precision NOT NULL,
    is_admin_approved character varying(255) DEFAULT 'no'::character varying NOT NULL,
    CONSTRAINT booking_qoutes_is_admin_approved_check CHECK (((is_admin_approved)::text = ANY ((ARRAY['no'::character varying, 'yes'::character varying])::text[]))),
    CONSTRAINT booking_qoutes_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'qouted'::character varying, 'accepted'::character varying, 'rejected'::character varying])::text[])))
);


ALTER TABLE public.booking_qoutes OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 42240)
-- Name: booking_qoutes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_qoutes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_qoutes_id_seq OWNER TO postgres;

--
-- TOC entry 4635 (class 0 OID 0)
-- Dependencies: 257
-- Name: booking_qoutes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_qoutes_id_seq OWNED BY public.booking_qoutes.id;


--
-- TOC entry 260 (class 1259 OID 42249)
-- Name: booking_reviews; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_reviews (
    id bigint NOT NULL,
    booking_id bigint NOT NULL,
    driver_id bigint NOT NULL,
    customer_id bigint NOT NULL,
    rate integer NOT NULL,
    comment text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    updated_by integer,
    CONSTRAINT booking_reviews_status_check CHECK (((status)::text = ANY (ARRAY[('pending'::character varying)::text, ('approve'::character varying)::text, ('disapprove'::character varying)::text])))
);


ALTER TABLE public.booking_reviews OWNER TO postgres;

--
-- TOC entry 259 (class 1259 OID 42248)
-- Name: booking_reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_reviews_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_reviews_id_seq OWNER TO postgres;

--
-- TOC entry 4636 (class 0 OID 0)
-- Dependencies: 259
-- Name: booking_reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_reviews_id_seq OWNED BY public.booking_reviews.id;


--
-- TOC entry 283 (class 1259 OID 57474)
-- Name: booking_status_trackings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_status_trackings (
    id bigint NOT NULL,
    booking_id integer NOT NULL,
    status_tracking character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT booking_status_trackings_status_tracking_check CHECK (((status_tracking)::text = ANY ((ARRAY['request_created'::character varying, 'qouted'::character varying, 'accepted'::character varying, 'journey_started'::character varying, 'item_collected'::character varying, 'on_the_way'::character varying, 'border_crossing'::character varying, 'custom_clearance'::character varying, 'delivered'::character varying])::text[])))
);


ALTER TABLE public.booking_status_trackings OWNER TO postgres;

--
-- TOC entry 282 (class 1259 OID 57473)
-- Name: booking_status_trackings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_status_trackings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_status_trackings_id_seq OWNER TO postgres;

--
-- TOC entry 4637 (class 0 OID 0)
-- Dependencies: 282
-- Name: booking_status_trackings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_status_trackings_id_seq OWNED BY public.booking_status_trackings.id;


--
-- TOC entry 268 (class 1259 OID 42321)
-- Name: bookings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bookings (
    id bigint NOT NULL,
    collection_address text NOT NULL,
    deliver_address text NOT NULL,
    sender_id bigint NOT NULL,
    receiver_name character varying(255) NOT NULL,
    receiver_email character varying(255) NOT NULL,
    receiver_phone character varying(255) NOT NULL,
    deligate_id bigint NOT NULL,
    deligate_details text NOT NULL,
    truck_type_id bigint,
    quantity integer NOT NULL,
    admin_response character varying(255) NOT NULL,
    qouted_amount double precision DEFAULT '0'::double precision,
    comission_amount double precision,
    customer_signature character varying(255) DEFAULT '0'::character varying,
    delivery_note text,
    driver_id bigint,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    awb_number character varying(255),
    booking_number character varying(255),
    is_paid character varying(255) DEFAULT 'no'::character varying NOT NULL,
    total_amount double precision DEFAULT '0'::double precision,
    shipping_method_id integer,
    invoice_number character varying(255),
    border_charges double precision DEFAULT '0'::double precision NOT NULL,
    shipping_charges double precision DEFAULT '0'::double precision NOT NULL,
    waiting_charges double precision DEFAULT '0'::double precision NOT NULL,
    custom_charges double precision DEFAULT '0'::double precision NOT NULL,
    cost_of_truck double precision DEFAULT '0'::double precision NOT NULL,
    received_amount double precision DEFAULT '0'::double precision NOT NULL,
    CONSTRAINT bookings_admin_response_check CHECK (((admin_response)::text = ANY (ARRAY[('pending'::character varying)::text, ('ask_for_qoute'::character varying)::text, ('driver_qouted'::character varying)::text, ('approved_by_admin'::character varying)::text]))),
    CONSTRAINT bookings_is_paid_check CHECK (((is_paid)::text = ANY ((ARRAY['no'::character varying, 'yes'::character varying])::text[]))),
    CONSTRAINT bookings_status_check CHECK (((status)::text = ANY (ARRAY[('pending'::character varying)::text, ('qouted'::character varying)::text, ('accepted'::character varying)::text, ('journey_started'::character varying)::text, ('item_collected'::character varying)::text, ('on_the_way'::character varying)::text, ('border_crossing'::character varying)::text, ('custom_clearance'::character varying)::text, ('delivered'::character varying)::text])))
);


ALTER TABLE public.bookings OWNER TO postgres;

--
-- TOC entry 269 (class 1259 OID 42328)
-- Name: bookings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bookings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bookings_id_seq OWNER TO postgres;

--
-- TOC entry 4638 (class 0 OID 0)
-- Dependencies: 269
-- Name: bookings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bookings_id_seq OWNED BY public.bookings.id;


--
-- TOC entry 227 (class 1259 OID 41059)
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    category_id integer NOT NULL,
    lang_code character varying(5) DEFAULT 'en'::character varying NOT NULL,
    category_name character varying(256) NOT NULL,
    unique_category_code character varying(128) NOT NULL,
    unique_category_text character varying(128) NOT NULL,
    category_image character varying(512),
    category_icon character varying(512),
    created_by integer NOT NULL,
    parent_category_id integer DEFAULT 0 NOT NULL,
    category_status smallint DEFAULT '1'::smallint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- TOC entry 4639 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.category_name; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.category_name IS 'should be in lowercase';


--
-- TOC entry 4640 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.unique_category_code; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.unique_category_code IS 'a unique code created during the category creation';


--
-- TOC entry 4641 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.unique_category_text; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.unique_category_text IS 'a unique code category text using category name field, usally used in website for better seo';


--
-- TOC entry 4642 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.category_image; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.category_image IS 'category image/logo file';


--
-- TOC entry 4643 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.category_icon; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.category_icon IS 'category image/logo file';


--
-- TOC entry 4644 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.category_status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.category_status IS '0-inactive,1-active';


--
-- TOC entry 226 (class 1259 OID 41058)
-- Name: categories_category_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_category_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categories_category_id_seq OWNER TO postgres;

--
-- TOC entry 4645 (class 0 OID 0)
-- Dependencies: 226
-- Name: categories_category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_category_id_seq OWNED BY public.categories.category_id;


--
-- TOC entry 229 (class 1259 OID 41071)
-- Name: category_languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.category_languages (
    category_lang_id integer NOT NULL,
    category_id_fk integer NOT NULL,
    lang_code character varying(5) NOT NULL,
    category_localized_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.category_languages OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 41070)
-- Name: category_languages_category_lang_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.category_languages_category_lang_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.category_languages_category_lang_id_seq OWNER TO postgres;

--
-- TOC entry 4646 (class 0 OID 0)
-- Dependencies: 228
-- Name: category_languages_category_lang_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.category_languages_category_lang_id_seq OWNED BY public.category_languages.category_lang_id;


--
-- TOC entry 285 (class 1259 OID 72014)
-- Name: cities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cities (
    id bigint NOT NULL,
    city_name character varying(255),
    city_status integer DEFAULT 0 NOT NULL,
    country_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.cities OWNER TO postgres;

--
-- TOC entry 284 (class 1259 OID 72013)
-- Name: cities_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cities_id_seq OWNER TO postgres;

--
-- TOC entry 4647 (class 0 OID 0)
-- Dependencies: 284
-- Name: cities_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cities_id_seq OWNED BY public.cities.id;


--
-- TOC entry 256 (class 1259 OID 42220)
-- Name: companies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.companies (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    logo character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    company_license character varying(255),
    user_id integer,
    license_expiry character varying(255),
    CONSTRAINT companies_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.companies OWNER TO postgres;

--
-- TOC entry 255 (class 1259 OID 42219)
-- Name: companies_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.companies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.companies_id_seq OWNER TO postgres;

--
-- TOC entry 4648 (class 0 OID 0)
-- Dependencies: 255
-- Name: companies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.companies_id_seq OWNED BY public.companies.id;


--
-- TOC entry 233 (class 1259 OID 41087)
-- Name: countries; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.countries (
    country_id integer NOT NULL,
    country_name character varying(128) NOT NULL,
    dial_code character varying(16) NOT NULL,
    iso_code character varying(16) NOT NULL,
    lang_code character varying(4) NOT NULL,
    country_status integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.countries OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 41086)
-- Name: countries_country_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.countries_country_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.countries_country_id_seq OWNER TO postgres;

--
-- TOC entry 4649 (class 0 OID 0)
-- Dependencies: 232
-- Name: countries_country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.countries_country_id_seq OWNED BY public.countries.country_id;


--
-- TOC entry 235 (class 1259 OID 41095)
-- Name: country_languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.country_languages (
    country_lang_id integer NOT NULL,
    lang_code character varying(4) NOT NULL,
    country_id_fk integer NOT NULL,
    country_localized_name character varying(128) NOT NULL
);


ALTER TABLE public.country_languages OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 41094)
-- Name: country_languages_country_lang_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.country_languages_country_lang_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.country_languages_country_lang_id_seq OWNER TO postgres;

--
-- TOC entry 4650 (class 0 OID 0)
-- Dependencies: 234
-- Name: country_languages_country_lang_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.country_languages_country_lang_id_seq OWNED BY public.country_languages.country_lang_id;


--
-- TOC entry 254 (class 1259 OID 42211)
-- Name: deligate_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.deligate_attributes (
    id bigint NOT NULL,
    deligate_id bigint NOT NULL,
    details text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    name character varying(255)
);


ALTER TABLE public.deligate_attributes OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 42210)
-- Name: deligate_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.deligate_attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.deligate_attributes_id_seq OWNER TO postgres;

--
-- TOC entry 4651 (class 0 OID 0)
-- Dependencies: 253
-- Name: deligate_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.deligate_attributes_id_seq OWNED BY public.deligate_attributes.id;


--
-- TOC entry 252 (class 1259 OID 42201)
-- Name: deligates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.deligates (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    icon character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    slug character varying(255),
    CONSTRAINT deligates_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.deligates OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 42200)
-- Name: deligates_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.deligates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.deligates_id_seq OWNER TO postgres;

--
-- TOC entry 4652 (class 0 OID 0)
-- Dependencies: 251
-- Name: deligates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.deligates_id_seq OWNED BY public.deligates.id;


--
-- TOC entry 248 (class 1259 OID 42180)
-- Name: driver_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.driver_details (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    driving_license character varying(255) NOT NULL,
    mulkia character varying(255) NOT NULL,
    mulkia_number character varying(255) NOT NULL,
    is_company character varying(255) DEFAULT 'no'::character varying NOT NULL,
    company_id bigint NOT NULL,
    truck_type_id bigint NOT NULL,
    total_rides integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    address character varying(255),
    latitude character varying(255),
    longitude character varying(255),
    emirates_id_or_passport character varying(255),
    driving_license_number character varying(255),
    driving_license_expiry date,
    driving_license_issued_by character varying(255),
    vehicle_plate_number character varying(255),
    vehicle_plate_place character varying(255),
    emirates_id_or_passport_back character varying(255),
    CONSTRAINT driver_details_is_company_check CHECK (((is_company)::text = ANY ((ARRAY['yes'::character varying, 'no'::character varying])::text[])))
);


ALTER TABLE public.driver_details OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 42179)
-- Name: driver_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.driver_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.driver_details_id_seq OWNER TO postgres;

--
-- TOC entry 4653 (class 0 OID 0)
-- Dependencies: 247
-- Name: driver_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.driver_details_id_seq OWNED BY public.driver_details.id;


--
-- TOC entry 267 (class 1259 OID 42282)
-- Name: driver_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.driver_types (
    id integer NOT NULL,
    type character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.driver_types OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 41121)
-- Name: event_invitations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.event_invitations (
    id bigint NOT NULL,
    event_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    is_allowed_to_invite boolean NOT NULL,
    show_guest_list boolean NOT NULL,
    status integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.event_invitations OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 41120)
-- Name: event_invitations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.event_invitations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.event_invitations_id_seq OWNER TO postgres;

--
-- TOC entry 4654 (class 0 OID 0)
-- Dependencies: 240
-- Name: event_invitations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.event_invitations_id_seq OWNED BY public.event_invitations.id;


--
-- TOC entry 239 (class 1259 OID 41111)
-- Name: events; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.events (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    date date NOT NULL,
    start_time character varying(255) NOT NULL,
    end_time character varying(255) NOT NULL,
    event_type_id integer NOT NULL,
    about text NOT NULL,
    privacy character varying(255) NOT NULL,
    image character varying(255) NOT NULL,
    address text NOT NULL,
    latitude character varying(255) NOT NULL,
    longitude character varying(255) NOT NULL,
    building character varying(255),
    apartment character varying(255),
    landmark character varying(255),
    active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.events OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 41110)
-- Name: events_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.events_id_seq OWNER TO postgres;

--
-- TOC entry 4655 (class 0 OID 0)
-- Dependencies: 238
-- Name: events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;


--
-- TOC entry 223 (class 1259 OID 41035)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 41034)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 4656 (class 0 OID 0)
-- Dependencies: 222
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 237 (class 1259 OID 41102)
-- Name: languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.languages (
    language_id integer NOT NULL,
    language_name character varying(255) NOT NULL,
    lang_code character varying(4) DEFAULT 'en'::character varying NOT NULL,
    language_status integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.languages OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 41101)
-- Name: languages_language_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.languages_language_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.languages_language_id_seq OWNER TO postgres;

--
-- TOC entry 4657 (class 0 OID 0)
-- Dependencies: 236
-- Name: languages_language_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.languages_language_id_seq OWNED BY public.languages.language_id;


--
-- TOC entry 216 (class 1259 OID 40999)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 40998)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 4658 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 271 (class 1259 OID 44950)
-- Name: new_notifications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.new_notifications (
    id bigint NOT NULL,
    user_id integer,
    description text,
    generated_by bigint,
    generated_to bigint,
    is_read character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    title character varying(255),
    image character varying(255),
    status character varying(255),
    CONSTRAINT new_notifications_is_read_check CHECK (((is_read)::text = ANY ((ARRAY['yes'::character varying, 'no'::character varying])::text[]))),
    CONSTRAINT new_notifications_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.new_notifications OWNER TO postgres;

--
-- TOC entry 270 (class 1259 OID 44949)
-- Name: new_notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.new_notifications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.new_notifications_id_seq OWNER TO postgres;

--
-- TOC entry 4659 (class 0 OID 0)
-- Dependencies: 270
-- Name: new_notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.new_notifications_id_seq OWNED BY public.new_notifications.id;


--
-- TOC entry 287 (class 1259 OID 72042)
-- Name: notification_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notification_users (
    id bigint NOT NULL,
    notification_id integer NOT NULL,
    user_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.notification_users OWNER TO postgres;

--
-- TOC entry 286 (class 1259 OID 72041)
-- Name: notification_users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notification_users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notification_users_id_seq OWNER TO postgres;

--
-- TOC entry 4660 (class 0 OID 0)
-- Dependencies: 286
-- Name: notification_users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notification_users_id_seq OWNED BY public.notification_users.id;


--
-- TOC entry 266 (class 1259 OID 42273)
-- Name: notifications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notifications (
    id bigint NOT NULL,
    type character varying(255) NOT NULL,
    content character varying(255) NOT NULL,
    generated_by bigint NOT NULL,
    generated_to bigint NOT NULL,
    is_read character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT notifications_is_read_check CHECK (((is_read)::text = ANY ((ARRAY['yes'::character varying, 'no'::character varying])::text[])))
);


ALTER TABLE public.notifications OWNER TO postgres;

--
-- TOC entry 265 (class 1259 OID 42272)
-- Name: notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notifications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notifications_id_seq OWNER TO postgres;

--
-- TOC entry 4661 (class 0 OID 0)
-- Dependencies: 265
-- Name: notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;


--
-- TOC entry 275 (class 1259 OID 49355)
-- Name: pages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pages (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    status integer DEFAULT 1 NOT NULL,
    slug character varying(255),
    description text,
    meta_title text,
    meta_keyword text,
    meta_description text,
    lang_code character varying(255) DEFAULT 'en'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.pages OWNER TO postgres;

--
-- TOC entry 274 (class 1259 OID 49354)
-- Name: pages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pages_id_seq OWNER TO postgres;

--
-- TOC entry 4662 (class 0 OID 0)
-- Dependencies: 274
-- Name: pages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pages_id_seq OWNED BY public.pages.id;


--
-- TOC entry 221 (class 1259 OID 41028)
-- Name: password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 41047)
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 41046)
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 4663 (class 0 OID 0)
-- Dependencies: 224
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- TOC entry 231 (class 1259 OID 41078)
-- Name: role_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role_permissions (
    permission_id integer NOT NULL,
    user_role_id_fk integer NOT NULL,
    module_key character varying(255) NOT NULL,
    permissions text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.role_permissions OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 41077)
-- Name: role_permissions_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.role_permissions_permission_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.role_permissions_permission_id_seq OWNER TO postgres;

--
-- TOC entry 4664 (class 0 OID 0)
-- Dependencies: 230
-- Name: role_permissions_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.role_permissions_permission_id_seq OWNED BY public.role_permissions.permission_id;


--
-- TOC entry 218 (class 1259 OID 41006)
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id integer NOT NULL,
    role character varying(255) NOT NULL,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    is_admin_role integer DEFAULT 0 NOT NULL,
    CONSTRAINT roles_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 41005)
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO postgres;

--
-- TOC entry 4665 (class 0 OID 0)
-- Dependencies: 217
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- TOC entry 279 (class 1259 OID 57416)
-- Name: shipping_methods; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.shipping_methods (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    icon character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT shipping_methods_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.shipping_methods OWNER TO postgres;

--
-- TOC entry 278 (class 1259 OID 57415)
-- Name: shipping_methods_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shipping_methods_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shipping_methods_id_seq OWNER TO postgres;

--
-- TOC entry 4666 (class 0 OID 0)
-- Dependencies: 278
-- Name: shipping_methods_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.shipping_methods_id_seq OWNED BY public.shipping_methods.id;


--
-- TOC entry 289 (class 1259 OID 115203)
-- Name: temp_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.temp_users (
    temp_user_id integer NOT NULL,
    truck_type character varying(255),
    account_type character varying(255),
    name character varying(255),
    email character varying(255),
    password character varying(255),
    dial_code character varying(255),
    phone character varying(255),
    driving_license character varying(255),
    company_id integer,
    emirates_id_or_passport character varying(255),
    emirates_id_or_passport_back character varying(255),
    user_device_type character varying(255),
    user_device_token character varying(255),
    user_device_id character varying(255),
    driving_license_number character varying(255),
    driving_license_expiry date,
    driving_license_issued_by character varying(255),
    vehicle_plate_number character varying(255),
    vehicle_plate_place character varying(255),
    mulkiya character varying(255),
    mulkiya_number character varying(255),
    status character varying(255),
    address character varying(255),
    country character varying(255),
    city character varying(255),
    zip_code character varying(255),
    latitude numeric(10,8),
    longitude numeric(11,8),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.temp_users OWNER TO postgres;

--
-- TOC entry 288 (class 1259 OID 115202)
-- Name: temp_users_temp_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.temp_users_temp_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.temp_users_temp_user_id_seq OWNER TO postgres;

--
-- TOC entry 4667 (class 0 OID 0)
-- Dependencies: 288
-- Name: temp_users_temp_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.temp_users_temp_user_id_seq OWNED BY public.temp_users.temp_user_id;


--
-- TOC entry 250 (class 1259 OID 42191)
-- Name: truck_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.truck_types (
    id bigint NOT NULL,
    truck_type character varying(255) NOT NULL,
    dimensions character varying(255) NOT NULL,
    icon character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    max_weight_in_tons character varying(255),
    CONSTRAINT truck_types_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.truck_types OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 42190)
-- Name: truck_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.truck_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.truck_types_id_seq OWNER TO postgres;

--
-- TOC entry 4668 (class 0 OID 0)
-- Dependencies: 249
-- Name: truck_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.truck_types_id_seq OWNED BY public.truck_types.id;


--
-- TOC entry 273 (class 1259 OID 49300)
-- Name: user_password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_password_resets (
    id bigint NOT NULL,
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    is_valid character varying(255) DEFAULT '0'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT user_password_resets_is_valid_check CHECK (((is_valid)::text = ANY ((ARRAY['1'::character varying, '0'::character varying])::text[])))
);


ALTER TABLE public.user_password_resets OWNER TO postgres;

--
-- TOC entry 272 (class 1259 OID 49299)
-- Name: user_password_resets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_password_resets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_password_resets_id_seq OWNER TO postgres;

--
-- TOC entry 4669 (class 0 OID 0)
-- Dependencies: 272
-- Name: user_password_resets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_password_resets_id_seq OWNED BY public.user_password_resets.id;


--
-- TOC entry 264 (class 1259 OID 42265)
-- Name: user_wallet_transactions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_wallet_transactions (
    id bigint NOT NULL,
    user_wallet_id bigint NOT NULL,
    amount integer NOT NULL,
    type character varying(255) NOT NULL,
    created_by bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT user_wallet_transactions_type_check CHECK (((type)::text = ANY ((ARRAY['credit'::character varying, 'debit'::character varying])::text[])))
);


ALTER TABLE public.user_wallet_transactions OWNER TO postgres;

--
-- TOC entry 263 (class 1259 OID 42264)
-- Name: user_wallet_transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_wallet_transactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_wallet_transactions_id_seq OWNER TO postgres;

--
-- TOC entry 4670 (class 0 OID 0)
-- Dependencies: 263
-- Name: user_wallet_transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_wallet_transactions_id_seq OWNED BY public.user_wallet_transactions.id;


--
-- TOC entry 262 (class 1259 OID 42258)
-- Name: user_wallets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_wallets (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    amount integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.user_wallets OWNER TO postgres;

--
-- TOC entry 261 (class 1259 OID 42257)
-- Name: user_wallets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_wallets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_wallets_id_seq OWNER TO postgres;

--
-- TOC entry 4671 (class 0 OID 0)
-- Dependencies: 261
-- Name: user_wallets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_wallets_id_seq OWNED BY public.user_wallets.id;


--
-- TOC entry 220 (class 1259 OID 41017)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255),
    email character varying(255),
    dial_code character varying(255),
    phone character varying(255),
    phone_verified integer DEFAULT 0 NOT NULL,
    password character varying(255),
    email_verified_at timestamp(0) without time zone,
    role_id bigint NOT NULL,
    user_phone_otp character varying(255),
    user_device_token character varying(255),
    user_device_type character varying(255),
    user_access_token character varying(255),
    firebase_user_key character varying(255),
    status character varying(255) DEFAULT 'inactive'::character varying NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    provider_id character varying(255),
    avatar character varying(255),
    address text,
    profile_image character varying(255),
    is_admin_access integer DEFAULT 0 NOT NULL,
    latitude character varying(255),
    longitude character varying(255),
    country character varying(255),
    city character varying(255),
    zip_code character varying(255),
    address_2 character varying(255),
    user_device_id character varying(255),
    fcm_token text,
    password_reset_otp character varying(255),
    password_reset_time character varying(255),
    login_type character varying(255) DEFAULT 'normal'::character varying NOT NULL,
    CONSTRAINT users_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 41016)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 4672 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 4297 (class 2604 OID 57372)
-- Name: blacklists id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.blacklists ALTER COLUMN id SET DEFAULT nextval('public.blacklists_id_seq'::regclass);


--
-- TOC entry 4299 (class 2604 OID 57442)
-- Name: booking_additional_charges id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_additional_charges ALTER COLUMN id SET DEFAULT nextval('public.booking_additional_charges_id_seq'::regclass);


--
-- TOC entry 4272 (class 2604 OID 42244)
-- Name: booking_qoutes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_qoutes ALTER COLUMN id SET DEFAULT nextval('public.booking_qoutes_id_seq'::regclass);


--
-- TOC entry 4275 (class 2604 OID 42252)
-- Name: booking_reviews id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_reviews ALTER COLUMN id SET DEFAULT nextval('public.booking_reviews_id_seq'::regclass);


--
-- TOC entry 4301 (class 2604 OID 57477)
-- Name: booking_status_trackings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_status_trackings ALTER COLUMN id SET DEFAULT nextval('public.booking_status_trackings_id_seq'::regclass);


--
-- TOC entry 4280 (class 2604 OID 42332)
-- Name: bookings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bookings ALTER COLUMN id SET DEFAULT nextval('public.bookings_id_seq'::regclass);


--
-- TOC entry 4250 (class 2604 OID 41062)
-- Name: categories category_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN category_id SET DEFAULT nextval('public.categories_category_id_seq'::regclass);


--
-- TOC entry 4254 (class 2604 OID 41074)
-- Name: category_languages category_lang_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_languages ALTER COLUMN category_lang_id SET DEFAULT nextval('public.category_languages_category_lang_id_seq'::regclass);


--
-- TOC entry 4302 (class 2604 OID 72017)
-- Name: cities id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cities ALTER COLUMN id SET DEFAULT nextval('public.cities_id_seq'::regclass);


--
-- TOC entry 4271 (class 2604 OID 42223)
-- Name: companies id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.companies ALTER COLUMN id SET DEFAULT nextval('public.companies_id_seq'::regclass);


--
-- TOC entry 4256 (class 2604 OID 41090)
-- Name: countries country_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries ALTER COLUMN country_id SET DEFAULT nextval('public.countries_country_id_seq'::regclass);


--
-- TOC entry 4258 (class 2604 OID 41098)
-- Name: country_languages country_lang_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.country_languages ALTER COLUMN country_lang_id SET DEFAULT nextval('public.country_languages_country_lang_id_seq'::regclass);


--
-- TOC entry 4270 (class 2604 OID 42214)
-- Name: deligate_attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligate_attributes ALTER COLUMN id SET DEFAULT nextval('public.deligate_attributes_id_seq'::regclass);


--
-- TOC entry 4269 (class 2604 OID 42204)
-- Name: deligates id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligates ALTER COLUMN id SET DEFAULT nextval('public.deligates_id_seq'::regclass);


--
-- TOC entry 4266 (class 2604 OID 42183)
-- Name: driver_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_details ALTER COLUMN id SET DEFAULT nextval('public.driver_details_id_seq'::regclass);


--
-- TOC entry 4264 (class 2604 OID 41124)
-- Name: event_invitations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_invitations ALTER COLUMN id SET DEFAULT nextval('public.event_invitations_id_seq'::regclass);


--
-- TOC entry 4262 (class 2604 OID 41114)
-- Name: events id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);


--
-- TOC entry 4247 (class 2604 OID 41038)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 4259 (class 2604 OID 41105)
-- Name: languages language_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages ALTER COLUMN language_id SET DEFAULT nextval('public.languages_language_id_seq'::regclass);


--
-- TOC entry 4238 (class 2604 OID 41002)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4291 (class 2604 OID 44953)
-- Name: new_notifications id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.new_notifications ALTER COLUMN id SET DEFAULT nextval('public.new_notifications_id_seq'::regclass);


--
-- TOC entry 4304 (class 2604 OID 72045)
-- Name: notification_users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification_users ALTER COLUMN id SET DEFAULT nextval('public.notification_users_id_seq'::regclass);


--
-- TOC entry 4279 (class 2604 OID 42276)
-- Name: notifications id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);


--
-- TOC entry 4294 (class 2604 OID 49358)
-- Name: pages id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages ALTER COLUMN id SET DEFAULT nextval('public.pages_id_seq'::regclass);


--
-- TOC entry 4249 (class 2604 OID 41050)
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- TOC entry 4255 (class 2604 OID 41081)
-- Name: role_permissions permission_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_permissions ALTER COLUMN permission_id SET DEFAULT nextval('public.role_permissions_permission_id_seq'::regclass);


--
-- TOC entry 4239 (class 2604 OID 41009)
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- TOC entry 4298 (class 2604 OID 57419)
-- Name: shipping_methods id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shipping_methods ALTER COLUMN id SET DEFAULT nextval('public.shipping_methods_id_seq'::regclass);


--
-- TOC entry 4305 (class 2604 OID 115206)
-- Name: temp_users temp_user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users ALTER COLUMN temp_user_id SET DEFAULT nextval('public.temp_users_temp_user_id_seq'::regclass);


--
-- TOC entry 4268 (class 2604 OID 42194)
-- Name: truck_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.truck_types ALTER COLUMN id SET DEFAULT nextval('public.truck_types_id_seq'::regclass);


--
-- TOC entry 4292 (class 2604 OID 49303)
-- Name: user_password_resets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_password_resets ALTER COLUMN id SET DEFAULT nextval('public.user_password_resets_id_seq'::regclass);


--
-- TOC entry 4278 (class 2604 OID 42268)
-- Name: user_wallet_transactions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallet_transactions ALTER COLUMN id SET DEFAULT nextval('public.user_wallet_transactions_id_seq'::regclass);


--
-- TOC entry 4277 (class 2604 OID 42261)
-- Name: user_wallets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallets ALTER COLUMN id SET DEFAULT nextval('public.user_wallets_id_seq'::regclass);


--
-- TOC entry 4242 (class 2604 OID 41020)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 4614 (class 0 OID 57369)
-- Dependencies: 277
-- Data for Name: blacklists; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.blacklists (id, user_id, user_device_id, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4618 (class 0 OID 57439)
-- Dependencies: 281
-- Data for Name: booking_additional_charges; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_additional_charges (id, booking_id, charges_name, charges_amount, created_at, updated_at) FROM stdin;
10	29	DDU	200	2023-05-24 04:22:09	2023-05-24 04:22:09
11	29	IDU	240	2023-05-24 04:22:09	2023-05-24 04:22:09
19	29	QTY	90	2023-05-24 05:13:19	2023-05-24 05:13:19
21	84	DDU	140	2023-05-24 05:22:19	2023-05-24 05:22:19
22	86	DDU	300	2023-06-01 20:45:02	2023-06-01 20:45:02
23	86	IPQ	200	2023-06-01 20:45:19	2023-06-01 20:45:19
\.


--
-- TOC entry 4595 (class 0 OID 42241)
-- Dependencies: 258
-- Data for Name: booking_qoutes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_qoutes (id, booking_id, driver_id, price, hours, status, created_at, updated_at, comission_amount, is_admin_approved) FROM stdin;
94	45	20	0	0	pending	2023-04-25 16:01:52	2023-04-25 16:01:52	0	no
95	46	20	230	20	qouted	2023-04-25 16:06:04	2023-04-25 16:14:21	0	yes
96	47	20	0	0	pending	2023-04-26 08:53:07	2023-04-26 08:53:07	0	no
97	47	20	0	0	pending	2023-04-26 08:53:50	2023-04-26 08:53:50	0	no
98	48	16	0	0	pending	2023-04-26 08:57:59	2023-04-26 08:57:59	0	no
101	51	20	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
102	51	16	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
103	52	20	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
126	85	20	1000	10	qouted	2023-05-24 05:50:24	2023-05-24 05:50:24	0	no
128	86	16	300	10	accepted	2023-06-01 16:42:27	2023-06-01 17:00:37	0	yes
125	84	20	8400	10	qouted	2023-05-22 23:12:50	2023-06-01 22:39:02	0	yes
99	50	20	2500	24	qouted	2023-04-26 09:47:36	2023-06-02 09:12:05	0	yes
104	52	16	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
105	53	20	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
100	50	16	3000	19	accepted	2023-04-26 09:47:36	2023-06-02 09:12:05	0	yes
127	86	20	200	4	rejected	2023-05-24 05:54:35	2023-05-24 05:54:35	0	no
106	53	16	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
107	54	20	0	0	pending	2023-04-26 14:00:08	2023-04-26 14:00:08	0	no
83	29	16	200	10	accepted	2023-04-24 23:44:40	2023-04-25 01:34:52	0	yes
108	54	16	0	0	pending	2023-04-26 14:00:08	2023-04-26 14:00:08	0	no
82	29	20	200	10	rejected	2023-04-24 23:44:40	2023-04-25 01:38:21	0	yes
109	55	20	0	0	pending	2023-04-26 14:00:08	2023-04-26 14:00:08	0	no
110	55	16	0	0	pending	2023-04-26 14:00:08	2023-04-26 14:00:08	0	no
111	57	20	0	0	pending	2023-04-26 14:00:08	2023-04-26 14:00:08	0	no
112	57	16	0	0	pending	2023-04-26 14:00:08	2023-04-26 14:00:08	0	no
113	59	20	0	0	pending	2023-04-26 14:02:31	2023-04-26 14:02:31	0	no
114	59	16	0	0	pending	2023-04-26 14:02:31	2023-04-26 14:02:31	0	no
115	61	20	0	0	pending	2023-04-26 14:04:45	2023-04-26 14:04:45	0	no
116	61	16	0	0	pending	2023-04-26 14:04:45	2023-04-26 14:04:45	0	no
117	62	16	0	0	pending	2023-04-27 09:12:41	2023-04-27 09:12:41	0	no
118	76	20	0	0	pending	2023-05-16 09:49:21	2023-05-16 09:49:21	0	no
119	78	20	0	0	pending	2023-05-16 10:17:20	2023-05-16 10:17:20	0	no
120	79	20	0	0	pending	2023-05-16 10:28:52	2023-05-16 10:28:52	0	no
121	80	20	0	0	pending	2023-05-16 10:51:46	2023-05-16 10:51:46	0	no
122	81	20	0	0	pending	2023-05-16 10:56:30	2023-05-16 10:56:30	0	no
123	82	20	0	0	pending	2023-05-16 10:58:59	2023-05-16 10:58:59	0	no
124	83	20	0	0	pending	2023-05-16 11:01:33	2023-05-16 11:01:33	0	no
129	86	45	400	6	rejected	2023-06-01 16:42:27	2023-06-01 17:00:37	0	yes
130	87	46	3400	14	qouted	2023-06-02 00:28:48	2023-06-02 00:28:48	0	no
132	89	46	7000	12	accepted	2023-06-02 10:05:10	2023-06-02 10:05:10	0	yes
\.


--
-- TOC entry 4597 (class 0 OID 42249)
-- Dependencies: 260
-- Data for Name: booking_reviews; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_reviews (id, booking_id, driver_id, customer_id, rate, comment, created_at, updated_at, status, updated_by) FROM stdin;
2	29	16	15	4	Awsome	2023-05-18 00:14:51	2023-06-02 20:50:20	approve	1
\.


--
-- TOC entry 4620 (class 0 OID 57474)
-- Dependencies: 283
-- Data for Name: booking_status_trackings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_status_trackings (id, booking_id, status_tracking, created_at, updated_at) FROM stdin;
1	84	request_created	2023-05-24 05:44:54	2023-05-24 05:45:00
2	84	qouted	2023-05-24 05:46:31	2023-05-24 05:46:31
3	85	request_created	2023-05-24 05:50:24	2023-05-24 05:50:24
4	85	qouted	2023-05-24 05:50:57	2023-05-24 05:50:57
5	86	request_created	2023-05-24 05:54:35	2023-05-24 05:54:35
6	84	accepted	2023-06-01 23:00:31	2023-06-01 23:00:31
7	84	journey_started	2023-06-01 23:00:38	2023-06-01 23:00:38
8	84	item_collected	2023-06-01 23:00:43	2023-06-01 23:00:43
9	84	on_the_way	2023-06-01 23:00:54	2023-06-01 23:00:54
10	84	border_crossing	2023-06-01 23:00:58	2023-06-01 23:00:58
11	84	custom_clearance	2023-06-01 23:01:04	2023-06-01 23:01:04
12	84	delivered	2023-06-01 23:11:06	2023-06-01 23:11:06
13	54	request_created	2023-06-01 23:12:30	2023-06-01 23:12:30
14	29	request_created	2023-06-01 23:15:58	2023-06-01 23:15:58
15	29	qouted	2023-06-01 23:16:04	2023-06-01 23:16:04
16	29	accepted	2023-06-01 23:16:09	2023-06-01 23:16:09
17	29	journey_started	2023-06-01 23:16:13	2023-06-01 23:16:13
18	29	item_collected	2023-06-01 23:16:22	2023-06-01 23:16:22
19	29	on_the_way	2023-06-01 23:16:29	2023-06-01 23:16:29
20	29	border_crossing	2023-06-01 23:16:37	2023-06-01 23:16:37
21	29	custom_clearance	2023-06-01 23:16:44	2023-06-01 23:16:44
22	29	delivered	2023-06-01 23:20:14	2023-06-01 23:20:14
23	46	request_created	2023-06-02 00:04:41	2023-06-02 00:04:41
24	46	qouted	2023-06-02 00:04:46	2023-06-02 00:04:46
25	87	request_created	2023-06-02 00:28:48	2023-06-02 00:28:48
26	86	qouted	2023-06-02 08:48:11	2023-06-02 08:48:11
27	86	accepted	2023-06-02 08:51:03	2023-06-02 08:51:03
28	83	request_created	2023-06-02 08:55:41	2023-06-02 08:55:41
29	50	request_created	2023-06-02 09:11:31	2023-06-02 09:11:31
30	50	qouted	2023-06-02 09:12:42	2023-06-02 09:12:42
31	50	journey_started	2023-06-02 09:26:56	2023-06-02 09:26:56
32	50	item_collected	2023-06-02 09:26:59	2023-06-02 09:26:59
33	50	on_the_way	2023-06-02 09:27:04	2023-06-02 09:27:04
34	88	request_created	2023-06-02 09:47:19	2023-06-02 09:47:19
35	89	request_created	2023-06-02 10:23:32	2023-06-02 10:23:32
36	89	qouted	2023-06-02 10:23:36	2023-06-02 10:23:36
37	89	accepted	2023-06-02 10:23:40	2023-06-02 10:23:40
38	89	journey_started	2023-06-02 10:23:45	2023-06-02 10:23:45
39	89	item_collected	2023-06-02 10:23:51	2023-06-02 10:23:51
40	89	on_the_way	2023-06-02 10:23:56	2023-06-02 10:23:56
41	89	border_crossing	2023-06-02 10:23:59	2023-06-02 10:23:59
42	89	custom_clearance	2023-06-02 10:24:04	2023-06-02 10:24:04
\.


--
-- TOC entry 4605 (class 0 OID 42321)
-- Dependencies: 268
-- Data for Name: bookings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bookings (id, collection_address, deliver_address, sender_id, receiver_name, receiver_email, receiver_phone, deligate_id, deligate_details, truck_type_id, quantity, admin_response, qouted_amount, comission_amount, customer_signature, delivery_note, driver_id, status, created_at, updated_at, awb_number, booking_number, is_paid, total_amount, shipping_method_id, invoice_number, border_charges, shipping_charges, waiting_charges, custom_charges, cost_of_truck, received_amount) FROM stdin;
88	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	57	Allen	allen@email.com	971 8858063	3	{"weight":"10","no_of_crts":"2","crt_dimension":"33","no_of_pallets":"2"}	\N	1	pending	0	5	0	\N	\N	pending	2023-06-02 09:47:19	2023-06-02 11:37:07	\N	#TX-000088	no	0	2	\N	0	0	0	0	0	0
49	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	Allen	allen@email.com	971 8858063	2	truck	2	1	pending	\N	3.2	sign.png	\N	\N	pending	2023-04-26 09:43:12	2023-06-02 09:31:50	\N	#TX-000049	no	\N	2	\N	0	0	0	0	0	0
89	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	57	Allen	allen@email.com	971 8858063	4	{"weight":"10","no_of_crts":"2","crt_dimension":"33","no_of_pallets":"2"}	2	1	approved_by_admin	7000	5	0	\N	46	custom_clearance	2023-06-02 09:47:19	2023-06-02 11:35:43	\N	#TX-000089	no	7700	2	138666	50	200	0	0	100	0
29	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	Daniel	daniel@email.com	971 181881818181	2	[]	2	1	approved_by_admin	200	4	sign.png	Successfully completed the booking	16	delivered	2023-04-24 23:43:51	2023-06-01 23:27:13	\N	#TX-000029	yes	800	2	\N	4	10	40	6	2	800
50	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	McCullum	mccullum@gmail.com	1 393839393	2	truck	2	1	approved_by_admin	3000	2	null	\N	16	on_the_way	2023-04-26 09:47:36	2023-06-02 09:29:22	\N	#TX-000050	no	3460	2	\N	50	120	0	30	200	2000
46	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	Allen	allen@email.com	971 8858063	2	truck	2	1	approved_by_admin	\N	0	sign.png	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,	\N	qouted	2023-04-25 16:06:04	2023-06-02 00:06:51	\N	#TX-000046	no	0	2	\N	0	0	0	0	0	0
79	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	32	Allen	allen@email.com	971 8858063	2	truck	2	1	ask_for_qoute	\N	0.2	sign.png	\N	\N	pending	2023-05-16 10:28:52	2023-05-16 10:28:53	\N	#TX-000079	no	\N	\N	\N	0	0	0	0	0	0
80	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	33	Allen	allen@email.com	971 8858063	2	truck	2	1	ask_for_qoute	\N	0.2	sign.png	\N	\N	pending	2023-05-16 10:51:46	2023-05-16 10:51:47	\N	#TX-000080	no	\N	\N	\N	0	0	0	0	0	0
81	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	34	Allen	allen@email.com	971 8858063	2	truck	2	1	ask_for_qoute	\N	0.2	sign.png	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,	\N	pending	2023-05-16 10:56:30	2023-05-16 10:56:31	\N	#TX-000081	no	\N	\N	\N	0	0	0	0	0	0
82	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	35	Allen	allen@email.com	971 8858063	2	truck	2	1	ask_for_qoute	\N	0.2	sign.png	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,	\N	pending	2023-05-16 10:58:59	2023-05-16 10:59:04	\N	#TX-000082	no	\N	\N	\N	0	0	0	0	0	0
83	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	36	Allen	allen@email.com	971 8858063	2	truck	2	1	ask_for_qoute	\N	0.2	sign.png	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,	\N	pending	2023-05-16 11:01:33	2023-06-02 08:56:46	\N	#TX-000083	no	\N	2	INVOICE-12	0	0	0	0	0	0
85	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	3	Daniel	daniel@email.com	43 3383838383838	2	truck	2	1	driver_qouted	\N	\N	sign.png	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,	\N	pending	2023-05-24 05:50:24	2023-06-02 09:09:42	\N	#TX-000085	no	\N	2	1883883	0	0	0	0	0	0
76	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	25	Allen	allen@email.com	971 8858063	2	truck	2	1	ask_for_qoute	\N	0	sign.png	\N	\N	pending	2023-05-16 09:49:21	2023-05-16 09:49:21	\N	#TX-000076	no	\N	\N	\N	0	0	0	0	0	0
84	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	Daniel	daniel@email.com	297 3939388383	2	truck	2	1	approved_by_admin	8400	1	sign.png	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,	20	delivered	2023-05-22 23:12:50	2023-06-01 23:11:06	\N	#TX-000084	yes	9074	2	3737373737	40	200	50	60	100	9074
78	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	30	Allen	allen@email.com	971 8858063	2	truck	2	1	pending	\N	0	sign.png	\N	\N	pending	2023-05-16 10:17:20	2023-05-16 10:17:20	\N	#TX-000078	no	\N	\N	\N	0	0	0	0	0	0
86	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	48	Allen	allen@email.com	971 8858063	2	truck	2	1	approved_by_admin	300	0.2	sign.png	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,	16	accepted	2023-05-24 05:54:35	2023-06-02 08:52:38	\N	#TX-000086	yes	970.6	2	\N	50	20	0	0	100	970.6
\.


--
-- TOC entry 4569 (class 0 OID 41059)
-- Dependencies: 227
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (category_id, lang_code, category_name, unique_category_code, unique_category_text, category_image, category_icon, created_by, parent_category_id, category_status, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- TOC entry 4571 (class 0 OID 41071)
-- Dependencies: 229
-- Data for Name: category_languages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category_languages (category_lang_id, category_id_fk, lang_code, category_localized_name, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4622 (class 0 OID 72014)
-- Dependencies: 285
-- Data for Name: cities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cities (id, city_name, city_status, country_id, created_at, updated_at) FROM stdin;
1	Dubai	1	1	2023-05-31 09:18:11	2023-05-31 09:27:24
3	Sharjah	1	1	2023-05-31 09:29:26	2023-05-31 09:29:26
\.


--
-- TOC entry 4593 (class 0 OID 42220)
-- Dependencies: 256
-- Data for Name: companies; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.companies (id, name, logo, status, created_at, updated_at, company_license, user_id, license_expiry) FROM stdin;
1	Timex Cargo	public/XpVbpZbXDlglKljK1MWWHHILbHyhm0LrKMQ21Gtw.png	active	2023-04-19 08:31:47	2023-05-18 12:00:11	\N	\N	\N
2	Timex Cargo	6440b17bac063_1681961339.jpg	active	2023-04-20 07:28:59	2023-05-18 12:21:29	6440b17baf008_1681961339.jpg	\N	\N
4	Timex Cargo Company	6465e1b208f47_1684398514.jpg	active	2023-05-18 10:26:42	2023-05-30 22:07:31	6465e1b211247_1684398514.jpg	44	2023-05-25
7	New Company	647a1d8632ad1_1685724550.jpg	active	2023-06-02 20:49:10	2023-06-02 20:49:10	647a1d86420d4_1685724550.jpg	58	2023-06-21
\.


--
-- TOC entry 4575 (class 0 OID 41087)
-- Dependencies: 233
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.countries (country_id, country_name, dial_code, iso_code, lang_code, country_status, created_at, updated_at, deleted_at) FROM stdin;
2	United States of America	1	USA	en	1	2023-05-18 13:09:04	2023-06-09 16:45:48	\N
1	United Arab Emirate	971	UAE	en	1	2023-05-18 13:07:55	2023-06-09 16:46:02	\N
\.


--
-- TOC entry 4577 (class 0 OID 41095)
-- Dependencies: 235
-- Data for Name: country_languages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.country_languages (country_lang_id, lang_code, country_id_fk, country_localized_name) FROM stdin;
\.


--
-- TOC entry 4591 (class 0 OID 42211)
-- Dependencies: 254
-- Data for Name: deligate_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.deligate_attributes (id, deligate_id, details, created_at, updated_at, name) FROM stdin;
13	1	{"input_type":"text","placeholder":"Weight   kg","label":"Weight   kg","name":"weight","fields":"1"}	2023-04-20 11:39:33	2023-04-20 11:39:33	weight
14	1	[]	2023-04-20 11:39:33	2023-04-20 11:39:33	no_of_crts
30	4	{"input_type":"text","placeholder":"Weight   kg","label":"Weight   kg","name":"weight","fields":"1"}	2023-04-24 20:20:40	2023-04-24 20:20:40	weight
31	4	[]	2023-04-24 20:20:40	2023-04-24 20:20:40	no_of_crts
32	4	{"input_type":"text","placeholder":"Cartn Dimension","label":"Cartn Dimension","name":"crt_dimension","fields":"1"}	2023-04-24 20:20:40	2023-04-24 20:20:40	crt_dimension
33	4	{"input_type":"text","placeholder":"No of Pallets","label":"No of Pallets","name":"no_of_pallets","fields":"1"}	2023-04-24 20:20:40	2023-04-24 20:20:40	no_of_pallets
34	3	{"input_type":"text","placeholder":"Weight   kg","label":"Weight   kg","name":"weight","fields":"1"}	2023-04-24 20:21:19	2023-04-24 20:21:19	weight
35	3	[]	2023-04-24 20:21:19	2023-04-24 20:21:19	no_of_crts
36	3	{"input_type":"text","placeholder":"Cartn Dimension","label":"Cartn Dimension","name":"crt_dimension","fields":"1"}	2023-04-24 20:21:19	2023-04-24 20:21:19	crt_dimension
37	3	{"input_type":"text","placeholder":"No of Pallets","label":"No of Pallets","name":"no_of_pallets","fields":"1"}	2023-04-24 20:21:19	2023-04-24 20:21:19	no_of_pallets
38	2	{"name":"truck","label":"Truck"}	2023-04-24 20:21:38	2023-04-24 20:21:38	truck
43	5	{"input_type":"text","placeholder":"Weight   kg","label":"Weight   kg","name":"weight","fields":"1"}	2023-04-24 20:22:52	2023-04-24 20:22:52	weight
44	5	[]	2023-04-24 20:22:52	2023-04-24 20:22:52	no_of_crts
45	5	{"input_type":"text","placeholder":"Cartn Dimension","label":"Cartn Dimension","name":"crt_dimension","fields":"1"}	2023-04-24 20:22:52	2023-04-24 20:22:52	crt_dimension
46	5	{"input_type":"text","placeholder":"No of Pallets","label":"No of Pallets","name":"no_of_pallets","fields":"1"}	2023-04-24 20:22:52	2023-04-24 20:22:52	no_of_pallets
47	5	[]	2023-04-24 20:22:52	2023-04-24 20:22:52	size[]
\.


--
-- TOC entry 4589 (class 0 OID 42201)
-- Dependencies: 252
-- Data for Name: deligates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.deligates (id, name, icon, status, created_at, updated_at, slug) FROM stdin;
4	Sea Frieght	6446ac58d0a08_1682353240.png	active	2023-04-24 20:20:40	2023-04-24 20:20:40	sea-frieght
3	Air Freight	6446ac7f4b9d5_1682353279.png	active	2023-04-20 11:46:45	2023-04-24 20:21:19	air-freight
2	Truck	6446ac92282c4_1682353298.png	active	2023-04-20 11:41:51	2023-04-24 20:21:38	truck
5	WareHouse	6446acca7c1e3_1682353354.png	active	2023-04-24 20:22:34	2023-04-24 20:22:34	warehouse
\.


--
-- TOC entry 4585 (class 0 OID 42180)
-- Dependencies: 248
-- Data for Name: driver_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.driver_details (id, user_id, driving_license, mulkia, mulkia_number, is_company, company_id, truck_type_id, total_rides, created_at, updated_at, address, latitude, longitude, emirates_id_or_passport, driving_license_number, driving_license_expiry, driving_license_issued_by, vehicle_plate_number, vehicle_plate_place, emirates_id_or_passport_back) FROM stdin;
9	11	643d8e3ec56fe_1681755710.png	643d8e3ec9c80_1681755710.png	2828828228	yes	1	2	0	2023-04-17 22:21:50	2023-04-17 22:21:50	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
11	18	643d8e3ec56fe_1681755710.png	643d8e3ec9c80_1681755710.png	2828828228	yes	1	2	0	2023-04-17 22:21:50	2023-04-17 22:21:50	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1	45	646611e7987be_1684410855.png	646611e89e145_1684410856.png	72727272772	yes	44	2	0	2023-05-18 15:54:16	2023-05-18 21:31:22	21 34 B St - Al Satwa - Dubai - United Arab Emirates	25.204819	55.270931	646660ea623dc_1684431082.jpg	22272727728	2023-05-23	United States of America	awwwww	NEW YORK	\N
2	46	64661a987d68f_1684413080.png	64661a98808c3_1684413080.png	727272727	no	0	2	0	2023-05-18 16:31:20	2023-05-19 09:14:12	Next to Post Office - Al Wasl Rd - Jumeirah 1 - Dubai - United Arab Emirates	25.204819	55.254117250442505	64661a9880e75_1684413080.png	22272727727	2023-05-31	United Arab Emirate	77277272727	Dubai	\N
3	53	6476c9625f50a_1685506402.jpg	6476c96262b46_1685506402.jpg	39393939393	no	0	2	0	2023-05-31 08:13:22	2023-05-31 08:25:14	8 22A Street - Za'abeel - Za'abeel 2 - Dubai - United Arab Emirates	25.204819	55.2907133102417	6476c96267d5a_1685506402.jpg	399393939393939	2023-05-18	United States of America	39393	Dubai	6476cc2aed1b4_1685507114.jpg
4	54	6476ccaf3e034_1685507247.jpg	6476ccaf40f66_1685507247.jpg	393938388	no	0	2	0	2023-05-31 08:27:27	2023-05-31 08:30:02	6737+VGR - Al Wasl - Dubai - United Arab Emirates	25.208862858631	55.27702331542969	6476ccaf415e6_1685507247.jpg	93399393939	2023-05-25	United Arab Emirate	33443333	Dubai	6476ccaf41bf8_1685507247.jpg
5	55	6476dd303f7ae_1685511472.jpg	6476dd3042986_1685511472.jpg	776644477	no	0	2	0	2023-05-31 09:37:52	2023-05-31 09:37:52	673C+W8X - Dubai - United Arab Emirates	25.20820277850409	55.27195930480957	6476dd3042f89_1685511472.jpg	944484848	2023-05-26	Sharjah	82828282828	Sharjah	6476dd3043546_1685511472.jpg
6	56	6476e7d434c2d_1685514196.jpg	6476e7d438519_1685514196.jpg	8665544	yes	44	2	0	2023-05-31 10:23:16	2023-05-31 10:23:16	673C+W8X - Dubai - United Arab Emirates	25.198916783959245	55.226723047492726	6476e7d43e7ea_1685514196.jpg	8786434890	2023-05-16	Dubai	855433	Sharjah	6476e7d43edd0_1685514196.jpg
10	20	6476ed8e37e88_1685515662.jpg	6476ed8e3a89f_1685515662.jpg	2828828228	yes	44	2	0	2023-04-17 22:21:50	2023-05-31 10:47:42	673C+W8X - Dubai - United Arab Emirates	25.207620351889865	55.26440620422363	6476ed8e3efa6_1685515662.jpg	876654446	2023-07-28	Dubai	8383883	Dubai	6476ed8e3f52b_1685515662.jpg
8	16	643d8e3ec56fe_1681755710.png	6478d4e16a121_1685640417.jpg	2828828228	yes	44	2	0	2023-04-17 22:21:50	2023-06-01 21:26:57	673C+W8X - Dubai - United Arab Emirates	25.214570460997496	55.303287506103516	6478d4e16cd65_1685640417.jpg	938383993	2023-08-25	Dubai	838838383	Dubai	6478d4e16d585_1685640417.jpg
\.


--
-- TOC entry 4604 (class 0 OID 42282)
-- Dependencies: 267
-- Data for Name: driver_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.driver_types (id, type, created_at, updated_at) FROM stdin;
0	Individual	\N	\N
1	Company	\N	\N
\.


--
-- TOC entry 4583 (class 0 OID 41121)
-- Dependencies: 241
-- Data for Name: event_invitations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.event_invitations (id, event_id, name, email, is_allowed_to_invite, show_guest_list, status, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4581 (class 0 OID 41111)
-- Dependencies: 239
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.events (id, name, date, start_time, end_time, event_type_id, about, privacy, image, address, latitude, longitude, building, apartment, landmark, active, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4565 (class 0 OID 41035)
-- Dependencies: 223
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- TOC entry 4579 (class 0 OID 41102)
-- Dependencies: 237
-- Data for Name: languages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.languages (language_id, language_name, lang_code, language_status, created_at, updated_at, deleted_at) FROM stdin;
1	English	en	1	2023-05-17 22:31:29	2023-05-17 22:31:29	\N
\.


--
-- TOC entry 4558 (class 0 OID 40999)
-- Dependencies: 216
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_roles_table	1
2	2014_10_12_100000_create_users_table	1
3	2014_10_12_200000_create_password_resets_table	1
4	2014_10_12_300000_create_failed_jobs_table	1
5	2019_12_14_000001_create_personal_access_tokens_table	1
6	2023_02_19_174049_create_categories_table	1
7	2023_02_23_161940_create_category_languages_table	1
8	2023_03_02_093403_create_role_permissions_table	1
9	2023_03_05_171740_create_table_countries	1
10	2023_03_05_172109_create_table_country_languages	1
11	2023_03_13_065242_create_languages_table	1
12	2023_03_17_101943_create_events_table	1
13	2023_03_17_103944_create_event_invitations_table	1
14	2023_03_28_231534_enable_postgis	1
15	2023_03_29_165153_add_coordinates_to_malls_table	1
16	2023_04_15_112135_add_socail_login_table	1
17	2023_04_15_134435_add_provider_to_users_table	1
18	2023_04_15_134617_add_avator_to_users_table	1
19	2023_04_15_172132_create_driver_details_table	1
20	2023_04_15_172206_create_truck_types_table	1
21	2023_04_15_172234_create_deligates_table	1
22	2023_04_15_172305_create_deligate_attributes_table	1
23	2023_04_15_172329_create_companies_table	1
24	2023_04_15_172402_create_bookings_table	1
25	2023_04_15_172442_create_booking_qoutes_table	1
26	2023_04_15_172522_create_booking_reviews_table	1
27	2023_04_15_172553_create_user_wallets_table	1
28	2023_04_15_172643_create_user_wallet_transactions_table	1
29	2023_04_15_172731_create_notifications_table	1
30	2023_04_15_184036_add_foreign_key_contraint_user_roles	1
31	2023_04_15_184120_add_foreign_key_contraint_driver_details	1
32	2023_04_15_190029_add_foreign_key_contraint_deligate_attributes	1
33	2023_04_15_190126_add_foreign_key_contraint_bookings	1
34	2023_04_15_190145_add_foreign_key_contraint_booking_qoutes	1
35	2023_04_15_190208_add_foreign_key_contraint_booking_reviews	1
36	2023_04_15_190256_add_foreign_key_contraint_user_wallets	1
37	2023_04_17_125531_create_driver_types_table	1
38	2023_04_17_193740_add_column_address_table	1
39	2023_04_18_192604_change_column_data_types	1
40	2023_04_18_193410_change_column_data_booking_qoutes_types	1
49	2023_04_19_090946_modify_driver_id_bookings_nullable	2
50	2023_04_19_165518_add_column_bookings_table	2
51	2023_04_19_165705_add_profile_image_users_table	2
52	2023_04_19_172013_add_commission_column_booking_qoutes	3
53	2023_04_19_140056_create_new_notifications_table	4
54	2023_04_19_184759_add_title_to_new_notificationa_table	4
55	2023_04_20_072743_add_company_license_column	5
56	2023_04_20_110505_add_column_deligate_attriibutes	6
57	2023_04_20_151756_add_column_is_admin_approved_in_booking_qoutes	7
58	2023_04_24_200623_add_column_slug_deligates_table	8
59	2023_04_24_232126_alter_column_bookings_truck_type_id_null	9
60	2023_04_25_193443_add_column_total_amount_bookings	10
61	2023_04_20_154913_add_location_to_driver_details_table	11
62	2023_04_20_155036_add_location_to_driver_details_table	11
63	2023_04_21_140650_add_image_new_notifications	11
65	2023_05_16_092913_create_user_password_resets	12
66	2023_04_26_120859_add_status_to_new_notifications_table	13
67	2023_04_27_110802_add_status_to_booking_reviews_table	13
68	2023_05_02_110342_add_paid_max_weight_in_tons_table	13
70	2023_05_17_094346_add_column_roles_is_admin	14
71	2023_05_17_151418_add_column_user_table_is_admin_access	15
72	2023_05_17_160522_add_columns_lat_log_users	16
75	2023_03_27_220811_create_pages_table	17
76	2023_05_17_224810_change_enum_values_in_reviews_table	17
77	2023_05_17_233635_add_column_booking_reviews_updated_by	18
78	2023_05_18_100623_add_colum_company_table_user_id	19
81	2023_05_18_151235_add_address_columns_users	20
82	2023_05_18_151349_add_documents_columns_driving_details	20
85	2023_05_19_121225_add_column_user_device_id_users	21
86	2023_05_19_121319_create_blacklist_tbale	21
87	2023_05_22_200422_create_shipping_methods_table	22
92	2023_05_22_225620_add_shipping_method_id_bookings	23
93	2023_05_22_234935_create_booking_charges_table	23
96	2023_05_24_052643_create_booking_status_trackings	24
97	2023_05_30_173001_add_license_expiry_companies	25
98	2023_05_31_080737_add_column_emirates_id_or_passport_back_driving_license	26
99	2023_05_31_084520_create_cities_table	27
100	2023_05_31_151832_add_column_received_amount_bookings	28
101	2023_06_01_203114_change_column_total_amount_type	29
103	2023_06_01_220716_change_customer_signature_column_type	30
104	2023_06_05_111123_remove_user_device_id_constraint	31
105	2023_06_05_125833_create_notification_users	32
106	2023_06_05_131348_change_new_notification_table	33
107	2023_06_06_130527_add_fcm_token_user	34
108	2023_06_07_104933_add_auth_columns_users	35
116	2023_07_20_144201_create_table_temp_users	36
\.


--
-- TOC entry 4608 (class 0 OID 44950)
-- Dependencies: 271
-- Data for Name: new_notifications; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.new_notifications (id, user_id, description, generated_by, generated_to, is_read, created_at, updated_at, title, image, status) FROM stdin;
1	20	New Notifications	\N	\N	\N	2023-04-20 07:45:33	2023-04-20 07:45:33	New Notification	\N	\N
2	16	New Notifications	\N	\N	\N	2023-04-20 07:45:33	2023-04-20 07:45:33	New Notification	\N	\N
3	15	New Notifications	\N	\N	\N	2023-04-20 07:45:33	2023-04-20 07:45:33	New Notification	\N	\N
4	2	My Custom Notification	\N	\N	\N	2023-04-26 09:34:47	2023-04-26 09:34:47	New Notification	6448b7f73bb45_1682487287.png	\N
5	3	My Custom Notification	\N	\N	\N	2023-04-26 09:34:47	2023-04-26 09:34:47	New Notification	6448b7f73ffce_1682487287.png	\N
6	5	My Custom Notification	\N	\N	\N	2023-04-26 09:34:47	2023-04-26 09:34:47	New Notification	6448b7f740bd7_1682487287.png	\N
7	\N	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	\N	\N	\N	2023-06-05 13:16:35	2023-06-05 13:16:35	Check Description	647da7f31396f_1685956595.png	active
\.


--
-- TOC entry 4624 (class 0 OID 72042)
-- Dependencies: 287
-- Data for Name: notification_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notification_users (id, notification_id, user_id, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4603 (class 0 OID 42273)
-- Dependencies: 266
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notifications (id, type, content, generated_by, generated_to, is_read, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4612 (class 0 OID 49355)
-- Dependencies: 275
-- Data for Name: pages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pages (id, title, status, slug, description, meta_title, meta_keyword, meta_description, lang_code, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4563 (class 0 OID 41028)
-- Dependencies: 221
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_resets (email, token, created_at) FROM stdin;
johnmarting12345@email.com	eyJpdiI6ImVqY1hHMG5Va3A5TjhGcnlNSHpoMFE9PSIsInZhbHVlIjoiRmJzMFp6a2FWV3QxdThsdWpob0xsZz09IiwibWFjIjoiN2U1YWIxMWE0ODFjYTBjZjM2NWZiMmFjYTMyNzI4MmFhOWNiOGE5MDdhYzk4MzllODU4ZDdkY2VkNzQ2NGYzNyIsInRhZyI6IiJ9	\N
\.


--
-- TOC entry 4567 (class 0 OID 41047)
-- Dependencies: 225
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at) FROM stdin;
1	App\\Models\\User	69	Personal Access Token	dd78fddf33f34f21b3ad7ad7e9c66ea9c0849431f6875a04ef793aad2159e8e4	["*"]	\N	2023-06-06 13:36:01	2023-06-06 13:36:01
2	App\\Models\\User	70	Personal Access Token	cba6c977587620c095811730e2e7892c3cfd6c1a974a2ad92a8e0cf7573029fa	["*"]	\N	2023-06-06 13:40:48	2023-06-06 13:40:48
3	App\\Models\\User	71	Personal Access Token	61f1c4a3c6c2522ea04fa0181ef6839aae154340e7c3c080bbca369c14e6db94	["*"]	\N	2023-06-06 13:49:41	2023-06-06 13:49:41
4	App\\Models\\User	71	71Abdul Ghanighaniabro11@gmail.com	eda6ba365e5338b2ba5dd153d25d75fd0982915009c379e6044f3cf024f23281	["*"]	\N	2023-06-06 15:51:40	2023-06-06 15:51:40
5	App\\Models\\User	71	71Abdul Ghanighaniabro11@gmail.com	102ac44f62067d567cf2fb5553b88882ffce1c3a880b8384372848a674f24880	["*"]	\N	2023-06-06 15:52:30	2023-06-06 15:52:30
6	App\\Models\\User	72	Personal Access Token	57b155e815d2556c43beeb3ae1dceeaef60f5d415445512d31427f2b1854e0c4	["*"]	\N	2023-06-07 09:39:17	2023-06-07 09:39:17
7	App\\Models\\User	72	72Abdul Ghanighaniabro11@gmail.com	3fa04d371fc601a1ecf71115f322013feeb96370e10f778c86183a85708535ff	["*"]	\N	2023-06-07 09:41:06	2023-06-07 09:41:06
8	App\\Models\\User	73	Personal Access Token	772b122d225ce14d72989e518bdad4a8be4c5689ae316d750c73ebf27fbcc18e	["*"]	\N	2023-06-07 09:48:13	2023-06-07 09:48:13
9	App\\Models\\User	74	Personal Access Token	1f30f251f6f7f4650f994cef0efaefc8e32590f00bec765cc72426057479fce9	["*"]	\N	2023-06-07 10:16:04	2023-06-07 10:16:04
10	App\\Models\\User	74	74Abdul Ghanighaniabro11@gmail.com	7a7cab4567eea1228df0ee030a3b1141fd928b94a48f7c09e79cf86d4b0a4a56	["*"]	\N	2023-06-07 10:20:47	2023-06-07 10:20:47
11	App\\Models\\User	74	74Abdul Ghanighaniabro11@gmail.com	e5353d559c779939095bef548318274879f1ad4ba0e17ee2cb1e26dbd7254bb0	["*"]	\N	2023-06-07 10:21:08	2023-06-07 10:21:08
12	App\\Models\\User	74	74Abdul Ghanighaniabro11@gmail.com	ff599103ebc07a318fc204f75f7eb015ba10aa74d0a2431b9e32ee2e5678af94	["*"]	\N	2023-06-07 14:56:19	2023-06-07 14:56:19
13	App\\Models\\User	74	74Abdul Ghanighaniabro11@gmail.com	facf08b9533a0acfef8253583eaa88c12331fcd6990f2b1a87ad10cff53718fe	["*"]	\N	2023-06-07 15:47:30	2023-06-07 15:47:30
14	App\\Models\\User	74	74Abdul Ghanighaniabro11@gmail.com	156771fb7c7ed451f6fe471602721ce1fc4a209cf925051942c71460f7e8efe4	["*"]	\N	2023-06-07 15:49:53	2023-06-07 15:49:53
15	App\\Models\\User	74	74Abdul Ghanighaniabro11@gmail.com	55b7cff9407f144a4843ccb98a911d8029e7ab66b5ade17a1740ffb148d7cb77	["*"]	\N	2023-06-07 15:56:14	2023-06-07 15:56:14
16	App\\Models\\User	75	Personal Access Token	436f59a763bdad18fc307688cf4f0924426884a7e643b15386d0d28ffa4914e8	["*"]	\N	2023-06-08 17:28:49	2023-06-08 17:28:49
\.


--
-- TOC entry 4573 (class 0 OID 41078)
-- Dependencies: 231
-- Data for Name: role_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role_permissions (permission_id, user_role_id_fk, module_key, permissions, created_at, updated_at) FROM stdin;
598	5	dashboard	["r"]	\N	\N
599	5	users	["r","u","d"]	\N	\N
600	5	drivers	["r","u","d"]	\N	\N
601	5	customers	["r","u","d"]	\N	\N
602	5	bookings	["r","u"]	\N	\N
603	5	earnings	["r","u","d"]	\N	\N
604	5	reviews	["r","u","d"]	\N	\N
605	5	notifications	["r","u","d"]	\N	\N
606	5	reports	["r","u","d"]	\N	\N
607	5	pages	["c","r","u","d"]	\N	\N
608	5	user_roles	["r","u","d"]	\N	\N
609	5	deligates	["r","u","d"]	\N	\N
610	5	company	["r","u","d"]	\N	\N
611	5	truck_types	["r","u","d"]	\N	\N
612	5	countries	["r","u","d"]	\N	\N
613	5	languages	["c","r","u","d"]	\N	\N
39	4	dashboard	["r"]	\N	\N
40	4	truck-drivers	["c","r","u","d"]	\N	\N
41	4	customers	["c","r","u","d"]	\N	\N
42	4	bookings	["c","r","u","d"]	\N	\N
43	4	earnings	["c","r","u","d"]	\N	\N
44	4	reviews	["c","r","u","d"]	\N	\N
45	4	notifications	["c","r","u","d"]	\N	\N
46	4	reports	["c","r","u","d"]	\N	\N
47	4	cms	["c","r","u","d"]	\N	\N
48	4	user-roles	["c","r","u","d"]	\N	\N
49	4	deligates	["c","r","u","d"]	\N	\N
50	4	companies	["c","r","u","d"]	\N	\N
51	4	truck-types	["c","r","u","d"]	\N	\N
52	4	countries	["c","r","u","d"]	\N	\N
53	4	languages	["c","r","u","d"]	\N	\N
59	7	dashboard	["r"]	\N	\N
69	6	dashboard	["r"]	\N	\N
70	6	admin-users	["c","r","u","d"]	\N	\N
71	6	truck-drivers	["c","r","u","d"]	\N	\N
72	6	customers	["c","r","u","d"]	\N	\N
73	6	bookings	["c","r","u","d"]	\N	\N
74	6	earnings	["c","r","u","d"]	\N	\N
75	6	reviews	["c","r","u","d"]	\N	\N
76	6	notifications	["c","r","u","d"]	\N	\N
\.


--
-- TOC entry 4560 (class 0 OID 41006)
-- Dependencies: 218
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, role, status, created_at, updated_at, deleted_at, is_admin_role) FROM stdin;
2	Truck Driver	active	2023-04-19 08:27:21	2023-04-19 08:27:21	\N	0
3	Customer	active	2023-04-19 08:27:21	2023-04-26 00:04:26	\N	0
4	Company	active	2023-05-17 14:33:28	2023-05-17 14:33:28	\N	0
1	Admin	active	2023-04-19 08:27:21	2023-04-19 08:27:21	\N	1
7	Author	active	2023-05-17 15:07:02	2023-05-17 15:07:02	\N	1
5	Manager	active	2023-05-17 15:02:09	2023-05-17 15:02:09	\N	1
6	Editor	active	2023-05-17 15:04:42	2023-05-17 15:04:42	\N	1
\.


--
-- TOC entry 4616 (class 0 OID 57416)
-- Dependencies: 279
-- Data for Name: shipping_methods; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.shipping_methods (id, name, icon, status, created_at, updated_at) FROM stdin;
2	Fedex	646b9bc859cf3_1684773832.png	active	2023-05-22 20:43:52	2023-05-22 20:45:57
\.


--
-- TOC entry 4237 (class 0 OID 41448)
-- Dependencies: 243
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.spatial_ref_sys (srid, auth_name, auth_srid, srtext, proj4text) FROM stdin;
\.


--
-- TOC entry 4626 (class 0 OID 115203)
-- Dependencies: 289
-- Data for Name: temp_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.temp_users (temp_user_id, truck_type, account_type, name, email, password, dial_code, phone, driving_license, company_id, emirates_id_or_passport, emirates_id_or_passport_back, user_device_type, user_device_token, user_device_id, driving_license_number, driving_license_expiry, driving_license_issued_by, vehicle_plate_number, vehicle_plate_place, mulkiya, mulkiya_number, status, address, country, city, zip_code, latitude, longitude, created_at, updated_at) FROM stdin;
5	2	1	Abdul Ghani	ghaniabro12@email.com	abc123	971	33838383	\N	44	\N	\N	android	882828282	12122112	\N	\N	\N	\N	\N	\N	\N	\N	Street 02 Northern Creek	United Arab Emirate	Dubai	9877	\N	\N	2023-07-21 11:19:22	2023-07-21 11:21:22
\.


--
-- TOC entry 4587 (class 0 OID 42191)
-- Dependencies: 250
-- Data for Name: truck_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.truck_types (id, truck_type, dimensions, icon, status, created_at, updated_at, max_weight_in_tons) FROM stdin;
2	1 Ton Side Grill	1x2x3	dummy.jpg	active	2023-04-17 19:12:43	2023-06-02 10:10:46	3
\.


--
-- TOC entry 4610 (class 0 OID 49300)
-- Dependencies: 273
-- Data for Name: user_password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_password_resets (id, email, token, is_valid, created_at, updated_at) FROM stdin;
3	seftware.testing@gmail.com	eyJpdiI6ImExZlpWM1pTWjhNV0J1RThXMVNodmc9PSIsInZhbHVlIjoibHIwZk0wUDJ0eUE4ckNwS3JmNWc5dz09IiwibWFjIjoiN2U2MjBjMzJkZmJiMWZhMjhkYTQ0ZTI1YTczOTUwNDk4Y2Y2OWEzNGYyNTc2NGRkMGUwNDYwMjMxYjAyYjM5ZSIsInRhZyI6IiJ9	1	2023-05-16 10:58:39	2023-05-16 10:58:39
4	seftware.testing@gmail.com	eyJpdiI6IjJiTy9RR0hnN3l3dnByRUdrTVFpcGc9PSIsInZhbHVlIjoiQ28xWE15eitrZWlueFVDajVwWXBHUT09IiwibWFjIjoiNzhkYTBhNmJjOWNiYjYyODVhNjUzNDk1ZTJkZTViYzNiZTMyMmM5MGI4MDY3NTkxZmQ1NWMxMjdjMzYyMDlmNSIsInRhZyI6IiJ9	0	2023-05-16 11:01:28	2023-05-16 11:01:28
5	mullen@email.com	eyJpdiI6IlZsVFo1MElnSlRxaGVncWVnc2t6MXc9PSIsInZhbHVlIjoieEVRcVZVQ2VER0pma1kzbGUyRGFDUT09IiwibWFjIjoiZTcxYmQwMDFhNzBkMjljMjMxM2RhNDFjNzRmYThiY2VmNTFhZWE0YjQ4Y2U1MmY5YWZiNzY3YmUwMjI2YzdlYyIsInRhZyI6IiJ9	1	2023-05-24 05:54:35	2023-05-24 05:54:35
6	benjamin@email.2	eyJpdiI6ImFFN0xNS1JEWXZoSU12TlZjeXE5UlE9PSIsInZhbHVlIjoicE9xWjVFUHRjbTlkWWV6OEkzdU5nZz09IiwibWFjIjoiZWU1NTk4YjkxZDM1YWU4OTRiZTI5MGY3Zjg4ZjRjNDYyMDhhN2JmYWUwODAyODQ1Y2RlOTBkZGUyZTU3MjFjOSIsInRhZyI6IiJ9	1	2023-06-02 09:47:19	2023-06-02 09:47:19
\.


--
-- TOC entry 4601 (class 0 OID 42265)
-- Dependencies: 264
-- Data for Name: user_wallet_transactions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_wallet_transactions (id, user_wallet_id, amount, type, created_by, created_at, updated_at) FROM stdin;
1	5	20	credit	1	2023-05-16 15:53:41	\N
2	15	400	credit	1	2023-05-16 16:01:12	\N
3	36	0	debit	1	2023-05-22 15:59:45	2023-05-22 15:59:45
\.


--
-- TOC entry 4599 (class 0 OID 42258)
-- Dependencies: 262
-- Data for Name: user_wallets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_wallets (id, user_id, amount, created_at, updated_at) FROM stdin;
1	2	10	2023-05-16 15:44:45	2023-05-16 15:44:45
2	8	50	2023-05-16 15:45:08	2023-05-16 15:45:08
3	5	20	2023-05-16 15:53:41	2023-05-16 15:53:41
4	15	400	2023-05-16 16:01:12	2023-05-16 16:01:12
6	47	0	2023-05-19 08:51:47	2023-05-19 08:51:47
5	36	200	2023-05-16 16:13:37	2023-05-16 16:13:37
\.


--
-- TOC entry 4562 (class 0 OID 41017)
-- Dependencies: 220
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, dial_code, phone, phone_verified, password, email_verified_at, role_id, user_phone_otp, user_device_token, user_device_type, user_access_token, firebase_user_key, status, remember_token, created_at, updated_at, deleted_at, provider_id, avatar, address, profile_image, is_admin_access, latitude, longitude, country, city, zip_code, address_2, user_device_id, fcm_token, password_reset_otp, password_reset_time, login_type) FROM stdin;
1	Admin	admin@admin.com	971	112233445566778899	0	$2y$10$vVRPq9LtGb7Q2gwtDgjCN.pA3A4OUSCKFTkDz9Mm18x5Wvq5TBa3a	\N	1	\N	\N	\N	\N	\N	inactive	\N	2023-04-19 08:27:22	2023-04-19 08:27:22	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	normal
75	Abdul Ghani	ghaniabro11@gmail.com	92	03142919268	1	$2y$10$p8UGi6s3E0u85RXLFQsZCOmu52lX1ZwFJfjcAyh7Sbfb/FmrBhS6W	2023-06-08 13:28:49	3		17737373	android	16|cetTBQ1QtvpT0w988F6C7nOPvGnVnQ9ZO7JMycsj	-NXQBWeydsf7XMYYe54d	active	\N	2023-06-08 13:28:49	2023-06-08 13:29:30	\N	\N	\N		\N	0			United Arab Emirate	Dubai	00000	ABC, DEF DUBAI	18272727	\N	\N	\N	normal
47	Brendon McCullum	brendon@gmail.com	+971	38338838	1	$2y$10$iVIABZe14rDdEemHY1ZUp..MCSK6QRkg0hOEbn1Mp5VoYU.sex7WO	2023-05-19 08:51:47	3	\N	\N	\N	\N	\N	active	\N	2023-05-19 08:51:47	2023-06-02 00:19:31	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.216472935629984	55.25294780731201	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
39	Admin User	newadminuser@email.com	43	232232233	1	$2y$10$n4BKYYpXGt5AyzXBTfvHROf2szH2j2U.YbzECXmAVXZEPxuV8/wym	2023-05-17 16:40:38	5	\N	\N	\N	\N	\N	active	\N	2023-05-17 15:30:35	2023-05-22 13:59:16	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	1	25.204819	55.26151108193968	\N	\N	\N	\N	\N	\N	\N	\N	normal
41	Michal	anotheruser@email.com	994	0292929221	1	$2y$10$LLKjBdwock8fAddh9E6PXOQVV/8D0/AtDKDF/OZRWC8x6YhXX4M0q	2023-06-02 10:08:34	7	\N	\N	\N	\N	\N	active	\N	2023-05-17 19:00:08	2023-06-05 10:04:12	\N	\N	\N	784G+XP - Port Saeed - Dubai - United Arab Emirates	\N	1	25.204819	55.3268323	\N	\N	\N	\N	\N	\N	\N	\N	normal
49	New Company	newcompany1@email.com	297	933939393939	1	$2y$10$KkBS4IHE/0wHVThg9jVH..aj7DJTTcB2K/HFs0GExx6xu3KQyeqai	2023-05-30 19:21:58	4	\N	\N	\N	\N	\N	active	\N	2023-05-30 19:21:58	2023-05-30 19:21:58	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.205440269253767	55.26009487557982	\N	\N	\N	\N	\N	\N	\N	\N	normal
50	New Company	newcompany444@email.com	297	933939399777	1	$2y$10$RfgKevAriiUttLj5SoBd6ObZjLARZkp/3yZJcyYAJ7.Arl9eBKbeG	2023-05-30 19:22:42	4	\N	\N	\N	\N	\N	active	\N	2023-05-30 19:22:42	2023-05-30 19:22:42	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.205440269253767	55.26009487557982	\N	\N	\N	\N	\N	\N	\N	\N	normal
36	John Martin	seftware.testing@gmail.com	+971	228282802	0	$2y$10$cjrEqFWucwNrFTDxvTw6GOCUNGK6CSw0EbHP.FDtxjKoXB3Jxl8O.	\N	3	\N	\N	\N	\N	\N	active	\N	2023-05-16 11:01:28	2023-06-02 00:26:43	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.207620351889865	55.26440620422363	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
4	Tennison	tennison@gmail.com	+971	97373737	1	$2y$10$TgQi9LGk5j2mAn/VpZtT9u1QKwpbdxgfdv8PLnCyTLQrae6NFTx9e	2023-04-20 07:42:36	3	\N	\N	\N	\N	\N	active	\N	2023-04-20 07:42:36	2023-06-05 12:45:05	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.21580723194398	55.303208587144304	United Arab Emirate	Dubai	0000	5th Floor 342 Apartment	88338383838	\N	\N	\N	normal
43	My New Company	newcompany@email.com	1	039393993	1	$2y$10$9765ofx.beEAKd8gL5yooeQio448RhUEBtnVO5arrNt0lwLwFVCzu	2023-05-18 10:21:52	4	\N	\N	\N	\N	\N	active	\N	2023-05-18 10:21:52	2023-05-18 12:24:56	2023-05-18 12:24:56	\N	\N	44 12 C St - Al Raffa - Dubai - United Arab Emirates	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	normal
40	Michal	michal@email.com	43	222222222	1	$2y$10$T.CXpIB1P7zgbILoYJFEcuXejMok83Ly93WnT3jUYP80806vFSdIC	2023-05-17 16:40:08	6	\N	\N	\N	\N	\N	active	\N	2023-05-17 16:40:08	2023-05-17 19:09:07	2023-05-17 19:09:07	\N	\N	8CWC+FC8 - Halwan Suburb - Al Abar - Sharjah - United Arab Emirates	\N	1	25.3461555	55.42109319999999	\N	\N	\N	\N	\N	\N	\N	\N	normal
2	Amelia	amelia@gmail.com	+971	29288228	1	$2y$10$0XWP2Gfq67CdVpFm6ombq.ThUj/PYqlxXsBUZV6ASGazyeZgyZxxm	2023-04-20 07:41:47	3	\N	\N	\N	\N	\N	active	\N	\N	2023-06-02 11:39:56	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.221597821322433	55.288310050964355	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
52	Check Company	checkcompany@email.com	297	848343848384	1	$2y$10$EecpcBGt0OZHizAcRoILhu2G9a69Py2qZmdm0OEMwbMiy6hZKtRPy	2023-05-30 21:50:20	4	\N	\N	\N	\N	\N	active	\N	2023-05-30 21:50:20	2023-05-30 21:51:17	2023-05-30 21:51:17	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.20804179981485	55.276617283111555	\N	\N	\N	\N	\N	\N	\N	\N	normal
45	Frank Caprio	frank@email.com	54	737373737	1	$2y$10$z5Jee1NPYK9kMwHrVxrNveCN9smyvAJCG2w/l0KAzyOWO39TJqy8m	2023-05-18 21:31:22	2	\N	\N	\N	\N	\N	active	\N	2023-05-18 15:54:15	2023-05-22 13:36:02	\N	\N	\N	21 34 B St - Al Satwa - Dubai - United Arab Emirates	\N	0	25.204819	55.270931	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
16	Micky Arthur	ghaniabro1123@gmail.com	971	322082992	1	$2y$10$f2zajjVynCk.0HQJg95l/.Dt0Do4B5fH.3L.O2KybyQ1QAXYPmuE.	2023-06-01 21:26:57	2	666					active		2023-04-17 22:21:50	2023-06-01 21:26:57	\N			673C+W8X - Dubai - United Arab Emirates	\N	0	25.214570460997496	55.303287506103516	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
44	Timex Cargo Company	timexcargo@email.com	1268	2228288282	1	$2y$10$MaTBjuseXrl5oGl7vkj5buDdcCeaZvu0qVmovdr0CfMgtUoNnbWza	2023-05-18 10:26:42	4	\N	\N	\N	\N	\N	active	\N	2023-05-18 10:26:42	2023-06-02 20:45:34	\N	\N	\N	1st Interchange, Shaikh Zayed Road - Al Safa St - next to Al Khazzan Park - Al Satwa - Dubai - United Arab Emirates	\N	0	25.20975590251652	55.2638053894043	United Arab Emirate	Sharjah	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
51	New Company	newcompany4433993@email.com	297	933939399939	1	$2y$10$dy2nSrGpTWBiieTLz.ZU6eTAyTbG6p6Z2WhuFOP/CM97JD5ELQP3i	2023-05-30 19:23:51	4	\N	\N	\N	\N	\N	active	\N	2023-05-30 19:23:51	2023-05-30 21:51:27	2023-05-30 21:51:27	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.205440269253767	55.26009487557982	\N	\N	\N	\N	\N	\N	\N	\N	normal
53	New Driver	newdriver@email.com	971	8388388338	1	$2y$10$BrZ2LP.eip5ajHcDiEV6Au0h8UgvQQwF7HpWN1Q2RXkY9nVXmYJCy	2023-05-31 08:25:14	2	\N	\N	\N	\N	\N	active	\N	2023-05-31 08:13:22	2023-05-31 08:25:14	\N	\N	\N	8 22A Street - Za'abeel - Za'abeel 2 - Dubai - United Arab Emirates	\N	0	25.204819	55.2907133102417	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
46	Tim Carter	timcarter@email.com	54	27272727	1	$2y$10$rDbJ/5YlXc6uLPWfCPmWWOfg/guxtSw2BFyxw2y68WGIwDz5WeFPG	2023-05-19 09:14:12	2	\N	\N	\N	\N	\N	active	\N	2023-05-18 16:31:20	2023-05-22 13:39:02	\N	\N	\N	Next to Post Office - Al Wasl Rd - Jumeirah 1 - Dubai - United Arab Emirates	\N	0	25.204819	55.254117250442505	United States of America	Santa Clara	00000	5th Floor, 342 Apartment	\N	\N	\N	\N	normal
54	Check New	check@email.com	971	339939393	1	$2y$10$pC1INLPut9hfjr5jAMBnMOzr8i7KScjZ.mMTiakxZOW9moKuPWtEG	2023-05-31 08:30:02	2	\N	\N	\N	\N	\N	inactive	\N	2023-05-31 08:27:27	2023-05-31 08:30:02	\N	\N	\N	6737+VGR - Al Wasl - Dubai - United Arab Emirates	\N	0	25.208862858631	55.27702331542969	United Arab Emirate	Dubai	000000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
55	Test Driver	testdriver@email.com	971	9383373	1	$2y$10$v.fElwsJONstF6x824PsZeFEimeNKAMfZV09EHYY9Fj1HnOsI4D9G	2023-05-31 10:14:53	2	\N	\N	\N	\N	\N	active	\N	2023-05-31 09:37:52	2023-05-31 10:14:53	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.20820277850409	55.27195930480957	United Arab Emirate	Sharjah	0000000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
56	Patrick	patrick@email.com	971	39393939	1	$2y$10$XlQaXR4uAtbmeRRyfhsTz.whffOAI3X1nY/yOVVEX.R3VNUmiN5vS	2023-05-31 10:24:50	2	\N	\N	\N	\N	\N	active	\N	2023-05-31 10:23:16	2023-05-31 10:24:50	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.198916783959245	55.226723047492726	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
20	Martin	softcube.web@gmail.com	971	1122333338	1	$2y$10$skQsMuozQI6Yb.gFN15w/uEcuz8/Gd5hb17jOLBlV25uHsX7cxYM2	2023-05-31 10:47:42	2	666					active		2023-04-17 22:21:50	2023-05-31 10:47:42	\N			673C+W8X - Dubai - United Arab Emirates	\N	0	25.207620351889865	55.26440620422363	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
8	John Martin	johnmarting@email.com	+971	29393939393	0	$2y$10$9C2FviM.TMn62PrCTxURIuVnGW0i8u/zu/LiIMt430kcnRPw6nZZu	\N	3	\N	\N	\N	\N	\N	active	\N	2023-05-15 23:42:19	2023-05-31 10:59:07	\N	\N	\N	Churchill Executive Tower - الخليج التجاري - دبي - United Arab Emirates	\N	0	25.204819	55.272887	United States of America	New York	091100	6th Floor Avenue	\N	\N	\N	\N	normal
48	Benjamin	benjamin@email.com	+971	816262681818	0	$2y$10$mYmgLJjlthpGB9eD5RcRM.Tj50CszJqQocfwwGUbGeGCCL0L/mGSK	\N	3	\N	\N	\N	\N	\N	active	\N	2023-05-24 05:54:35	2023-06-02 00:13:13	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.213211532333823	55.24869918823242	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
15	Abdul Ghani	seftware1.testing@gmail.com	971	11223382828	1	$2y$10$HgaFVd4fMNawbiIWnMwl5uy4950OiwEYycWEZrh.KIuVudgax0aNa	2023-04-17 22:21:50	3	666					active		2023-04-17 22:21:50	2023-06-02 00:27:08	\N			673C+W8X - Dubai - United Arab Emirates	\N	0	25.20707675120213	55.254106521606445	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
57	Benjamin	benjamin@email.2	\N	\N	0	$2y$10$FB7aQZ10Ed9QLomZHGKmreRCDx.LfsG.DxY0FMC4jsq27slYp0/8y	\N	3	\N	\N	\N	\N	\N	active	\N	2023-06-02 09:47:19	2023-06-02 09:47:19	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	normal
58	New Company	newcompany12@email.com	971	93939393939	1	$2y$10$npZQCcAsnQh.aillc3IAkuCwwWNwzrUW94g7amYMH/nrFGH0OJJki	2023-06-02 20:49:10	4	\N	\N	\N	\N	\N	active	\N	2023-06-02 20:49:10	2023-06-02 20:49:10	\N	\N	\N	82b 32 C St - Jumeirah - Jumeirah 1 - Dubai - United Arab Emirates	\N	0	25.20998320430137	55.25477337289427	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	\N	\N	\N	\N	normal
3	Michal Clark	clark@gmail.com	+1	922872772992	1	$2y$10$4K5JMACY.pyojhhxbny6xO2Mj4XYHV2EHi8VpN1UaITt/qMAgLqqq	2023-04-20 07:41:48	3	\N	\N	\N	\N	\N	active	\N	\N	2023-06-05 12:54:34	\N	\N	\N	By appointment only, Brooklyn, NY 11201, USA	\N	0	25.204819	-73.98356482988109	United States of America	New York	00000	\N	27182828	\N	\N	\N	normal
5	Jack Ethan	jack@gmail.com	+971	29288228	1	$2y$10$9CyA/CzU4ptRcr7YY7Gwve9zvrWl0EV5XRUBf8Egn6Qf9wsEXMfgS	2023-04-20 07:54:20	3	\N	\N	\N	\N	\N	active	\N	\N	2023-06-05 12:54:57	\N	\N	\N	673C+W8X - Dubai - United Arab Emirates	\N	0	25.20707675120213	55.254106521606445	United Arab Emirate	Dubai	00000	5th Floor 342 Apartment	27182828	\N	\N	\N	normal
\.


--
-- TOC entry 4673 (class 0 OID 0)
-- Dependencies: 276
-- Name: blacklists_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.blacklists_id_seq', 61, true);


--
-- TOC entry 4674 (class 0 OID 0)
-- Dependencies: 280
-- Name: booking_additional_charges_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_additional_charges_id_seq', 23, true);


--
-- TOC entry 4675 (class 0 OID 0)
-- Dependencies: 257
-- Name: booking_qoutes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_qoutes_id_seq', 133, true);


--
-- TOC entry 4676 (class 0 OID 0)
-- Dependencies: 259
-- Name: booking_reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_reviews_id_seq', 2, true);


--
-- TOC entry 4677 (class 0 OID 0)
-- Dependencies: 282
-- Name: booking_status_trackings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_status_trackings_id_seq', 42, true);


--
-- TOC entry 4678 (class 0 OID 0)
-- Dependencies: 269
-- Name: bookings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bookings_id_seq', 89, true);


--
-- TOC entry 4679 (class 0 OID 0)
-- Dependencies: 226
-- Name: categories_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_category_id_seq', 1, false);


--
-- TOC entry 4680 (class 0 OID 0)
-- Dependencies: 228
-- Name: category_languages_category_lang_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.category_languages_category_lang_id_seq', 1, false);


--
-- TOC entry 4681 (class 0 OID 0)
-- Dependencies: 284
-- Name: cities_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cities_id_seq', 3, true);


--
-- TOC entry 4682 (class 0 OID 0)
-- Dependencies: 255
-- Name: companies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.companies_id_seq', 7, true);


--
-- TOC entry 4683 (class 0 OID 0)
-- Dependencies: 232
-- Name: countries_country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.countries_country_id_seq', 2, true);


--
-- TOC entry 4684 (class 0 OID 0)
-- Dependencies: 234
-- Name: country_languages_country_lang_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.country_languages_country_lang_id_seq', 1, false);


--
-- TOC entry 4685 (class 0 OID 0)
-- Dependencies: 253
-- Name: deligate_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.deligate_attributes_id_seq', 47, true);


--
-- TOC entry 4686 (class 0 OID 0)
-- Dependencies: 251
-- Name: deligates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.deligates_id_seq', 5, true);


--
-- TOC entry 4687 (class 0 OID 0)
-- Dependencies: 247
-- Name: driver_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.driver_details_id_seq', 6, true);


--
-- TOC entry 4688 (class 0 OID 0)
-- Dependencies: 240
-- Name: event_invitations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.event_invitations_id_seq', 1, false);


--
-- TOC entry 4689 (class 0 OID 0)
-- Dependencies: 238
-- Name: events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.events_id_seq', 1, false);


--
-- TOC entry 4690 (class 0 OID 0)
-- Dependencies: 222
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 4691 (class 0 OID 0)
-- Dependencies: 236
-- Name: languages_language_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.languages_language_id_seq', 1, true);


--
-- TOC entry 4692 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 116, true);


--
-- TOC entry 4693 (class 0 OID 0)
-- Dependencies: 270
-- Name: new_notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.new_notifications_id_seq', 8, true);


--
-- TOC entry 4694 (class 0 OID 0)
-- Dependencies: 286
-- Name: notification_users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notification_users_id_seq', 24, true);


--
-- TOC entry 4695 (class 0 OID 0)
-- Dependencies: 265
-- Name: notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notifications_id_seq', 1, false);


--
-- TOC entry 4696 (class 0 OID 0)
-- Dependencies: 274
-- Name: pages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pages_id_seq', 1, false);


--
-- TOC entry 4697 (class 0 OID 0)
-- Dependencies: 224
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 16, true);


--
-- TOC entry 4698 (class 0 OID 0)
-- Dependencies: 230
-- Name: role_permissions_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.role_permissions_permission_id_seq', 613, true);


--
-- TOC entry 4699 (class 0 OID 0)
-- Dependencies: 217
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 7, true);


--
-- TOC entry 4700 (class 0 OID 0)
-- Dependencies: 278
-- Name: shipping_methods_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.shipping_methods_id_seq', 2, true);


--
-- TOC entry 4701 (class 0 OID 0)
-- Dependencies: 288
-- Name: temp_users_temp_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.temp_users_temp_user_id_seq', 5, true);


--
-- TOC entry 4702 (class 0 OID 0)
-- Dependencies: 249
-- Name: truck_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.truck_types_id_seq', 1, false);


--
-- TOC entry 4703 (class 0 OID 0)
-- Dependencies: 272
-- Name: user_password_resets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_password_resets_id_seq', 6, true);


--
-- TOC entry 4704 (class 0 OID 0)
-- Dependencies: 263
-- Name: user_wallet_transactions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_wallet_transactions_id_seq', 3, true);


--
-- TOC entry 4705 (class 0 OID 0)
-- Dependencies: 261
-- Name: user_wallets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_wallets_id_seq', 6, true);


--
-- TOC entry 4706 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 77, true);


--
-- TOC entry 4390 (class 2606 OID 57374)
-- Name: blacklists blacklists_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.blacklists
    ADD CONSTRAINT blacklists_pkey PRIMARY KEY (id);


--
-- TOC entry 4394 (class 2606 OID 57445)
-- Name: booking_additional_charges booking_additional_charges_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_additional_charges
    ADD CONSTRAINT booking_additional_charges_pkey PRIMARY KEY (id);


--
-- TOC entry 4371 (class 2606 OID 42247)
-- Name: booking_qoutes booking_qoutes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_qoutes
    ADD CONSTRAINT booking_qoutes_pkey PRIMARY KEY (id);


--
-- TOC entry 4373 (class 2606 OID 42256)
-- Name: booking_reviews booking_reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_reviews
    ADD CONSTRAINT booking_reviews_pkey PRIMARY KEY (id);


--
-- TOC entry 4396 (class 2606 OID 57480)
-- Name: booking_status_trackings booking_status_trackings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_status_trackings
    ADD CONSTRAINT booking_status_trackings_pkey PRIMARY KEY (id);


--
-- TOC entry 4381 (class 2606 OID 42331)
-- Name: bookings bookings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bookings
    ADD CONSTRAINT bookings_pkey PRIMARY KEY (id);


--
-- TOC entry 4343 (class 2606 OID 41069)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (category_id);


--
-- TOC entry 4345 (class 2606 OID 41076)
-- Name: category_languages category_languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_languages
    ADD CONSTRAINT category_languages_pkey PRIMARY KEY (category_lang_id);


--
-- TOC entry 4398 (class 2606 OID 72020)
-- Name: cities cities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cities
    ADD CONSTRAINT cities_pkey PRIMARY KEY (id);


--
-- TOC entry 4369 (class 2606 OID 42228)
-- Name: companies companies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_pkey PRIMARY KEY (id);


--
-- TOC entry 4349 (class 2606 OID 41093)
-- Name: countries countries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (country_id);


--
-- TOC entry 4351 (class 2606 OID 41100)
-- Name: country_languages country_languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.country_languages
    ADD CONSTRAINT country_languages_pkey PRIMARY KEY (country_lang_id);


--
-- TOC entry 4367 (class 2606 OID 42218)
-- Name: deligate_attributes deligate_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligate_attributes
    ADD CONSTRAINT deligate_attributes_pkey PRIMARY KEY (id);


--
-- TOC entry 4365 (class 2606 OID 42209)
-- Name: deligates deligates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligates
    ADD CONSTRAINT deligates_pkey PRIMARY KEY (id);


--
-- TOC entry 4361 (class 2606 OID 42189)
-- Name: driver_details driver_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_details
    ADD CONSTRAINT driver_details_pkey PRIMARY KEY (id);


--
-- TOC entry 4357 (class 2606 OID 41129)
-- Name: event_invitations event_invitations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_invitations
    ADD CONSTRAINT event_invitations_pkey PRIMARY KEY (id);


--
-- TOC entry 4355 (class 2606 OID 41119)
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- TOC entry 4334 (class 2606 OID 41043)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4336 (class 2606 OID 41045)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 4353 (class 2606 OID 41109)
-- Name: languages languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_pkey PRIMARY KEY (language_id);


--
-- TOC entry 4327 (class 2606 OID 41004)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 4383 (class 2606 OID 44958)
-- Name: new_notifications new_notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.new_notifications
    ADD CONSTRAINT new_notifications_pkey PRIMARY KEY (id);


--
-- TOC entry 4400 (class 2606 OID 72047)
-- Name: notification_users notification_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification_users
    ADD CONSTRAINT notification_users_pkey PRIMARY KEY (id);


--
-- TOC entry 4379 (class 2606 OID 42281)
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- TOC entry 4388 (class 2606 OID 49364)
-- Name: pages pages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (id);


--
-- TOC entry 4338 (class 2606 OID 41054)
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 4340 (class 2606 OID 41057)
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- TOC entry 4347 (class 2606 OID 41085)
-- Name: role_permissions role_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_permissions
    ADD CONSTRAINT role_permissions_pkey PRIMARY KEY (permission_id);


--
-- TOC entry 4329 (class 2606 OID 41015)
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- TOC entry 4392 (class 2606 OID 57424)
-- Name: shipping_methods shipping_methods_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shipping_methods
    ADD CONSTRAINT shipping_methods_pkey PRIMARY KEY (id);


--
-- TOC entry 4402 (class 2606 OID 115216)
-- Name: temp_users temp_users_driving_license_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users
    ADD CONSTRAINT temp_users_driving_license_number_unique UNIQUE (driving_license_number);


--
-- TOC entry 4404 (class 2606 OID 115212)
-- Name: temp_users temp_users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users
    ADD CONSTRAINT temp_users_email_unique UNIQUE (email);


--
-- TOC entry 4406 (class 2606 OID 115214)
-- Name: temp_users temp_users_phone_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users
    ADD CONSTRAINT temp_users_phone_unique UNIQUE (phone);


--
-- TOC entry 4408 (class 2606 OID 115210)
-- Name: temp_users temp_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users
    ADD CONSTRAINT temp_users_pkey PRIMARY KEY (temp_user_id);


--
-- TOC entry 4363 (class 2606 OID 42199)
-- Name: truck_types truck_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.truck_types
    ADD CONSTRAINT truck_types_pkey PRIMARY KEY (id);


--
-- TOC entry 4386 (class 2606 OID 49309)
-- Name: user_password_resets user_password_resets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_password_resets
    ADD CONSTRAINT user_password_resets_pkey PRIMARY KEY (id);


--
-- TOC entry 4377 (class 2606 OID 42271)
-- Name: user_wallet_transactions user_wallet_transactions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallet_transactions
    ADD CONSTRAINT user_wallet_transactions_pkey PRIMARY KEY (id);


--
-- TOC entry 4375 (class 2606 OID 42263)
-- Name: user_wallets user_wallets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallets
    ADD CONSTRAINT user_wallets_pkey PRIMARY KEY (id);


--
-- TOC entry 4331 (class 2606 OID 41027)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 4332 (class 1259 OID 41033)
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- TOC entry 4341 (class 1259 OID 41055)
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- TOC entry 4384 (class 1259 OID 49310)
-- Name: user_password_resets_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX user_password_resets_email_index ON public.user_password_resets USING btree (email);


--
-- TOC entry 4409 (class 2606 OID 41130)
-- Name: event_invitations event_invitations_event_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_invitations
    ADD CONSTRAINT event_invitations_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id);


-- Completed on 2023-07-24 14:09:28

--
-- PostgreSQL database dump complete
--

